<?php
/**
 * Created by PhpStorm.
 * User: win
 * Date: 2020-11-09
 * Time: 上午 11:53
 */
namespace App\Http\Controllers;
use App\Cache\Redis\FileCache;
use App\Entity\File;
use App\Result\ResponseResult;
use App\Service\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    private $fileService = null;
    private $fileCache = null;


    /**
     * FileController constructor.
     * @param FileService $fileService
     * @param FileCache $fileCache
     */
    public function __construct(FileService $fileService, FileCache $fileCache)
    {
        $this->fileService = $fileService;
        $this->fileCache = $fileCache;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view("file/index");
    }

    /**
     * 获取已上传的文件列表
     */
    public function getFileList(Request $request)
    {
        //分页获取
        $minId = $request->get("minId", 0);
        if ($minId == 0) {
            $fileList = \App\Model\File::select('unique_id', 'uid', 'title', 'desc', 'cover', 'created_at', 'file_type')
                ->orderBy("created_at", "desc")
                ->take(10)
                ->get();
        } else {
            $fileList = \App\Model\File::where('id', "lt", $minId)
                ->select('unique_id', 'uid', 'title', 'desc', 'cover', 'created_at', 'file_type')
                ->orderBy("created_at", "desc")
                ->take(10)
                ->get();
        }

        return $fileList;
    }

    /**
     * 上传图片页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function uploadFilePage()
    {
        return view("file/img/upload");
    }

    /**
     * 保存用户上传文件 提交表单
     * @param Request $request
     * @return array
     */
    public function storeFileUploadInfo(Request $request)
    {
        //获取参数
        $title = $request->get('title', '');
        $desc = $request->get('desc', '');
        $coverUrl = $request->get('cover_url', '');
        $fileUrl = $request->get('fileListInfo', '');
        $fileType = $request->get('fileType', '');
        $file = new File();
        //文件类型 图片 语音 文档 视频
        $file->setFileType($fileType);
        $file->setDesc($desc);
        $file->setTitle($title);
        $file->setCover($coverUrl);
        $file->setUid(Auth::user()->id);
        //生成每次上传的唯一id TODO使用雪花算法生成唯一id
        $file->setIdentifyId(FileService::getUniqueId($title . $desc));
        //获取文件地址
        $src = implode(',', array_column($fileUrl, 'src'));
        $totalSize = array_sum(array_column($fileUrl, 'size'));
        $file->setFileUrl($src);
        $file->setFileSize($totalSize);
        $addRes = $this->fileService->saveFileItem($file);
        //添加图片
        if ($addRes instanceof \App\Model\File) {
            return ResponseResult::getResponse(ResponseResult::SUCCESS_COM);
        }
        //添加失败，删除上传的文件
        foreach ($fileUrl as $tmpFile) {
            //删除文件
            Storage::delete($tmpFile['src']);
        }
        return ResponseResult::getResponse(ResponseResult::FAIL_SERVICE_ADD);
    }

    /**
     * 上传封面接口 | 异步上传文件
     * @param Request $request
     * @return array
     */
    public function uploadFileCover(Request $request)
    {
        $uploadFileObj = $request->file('file');
        if (is_null($uploadFileObj)) {
            return ResponseResult::getResponse(ResponseResult::FAIL_PARAM_ILLEGAL);
        }
        $checkRes = $this->fileService->checkFile($uploadFileObj, "img");
        if ($checkRes !== true) {
            return ResponseResult::getResponse($checkRes);
        }
        return $this->storeFile($uploadFileObj, 1);
    }

    /**
     * 保存文件 | 异步上传文件
     * @param Request $request
     * @return array
     */
    public function saveFile(Request $request)
    {
        //获取上传文件的类型
        $fileType = $request->get("fileType");
        $uploadFileObj = $request->file('file');
        if (is_null($uploadFileObj)) {
            return ResponseResult::getResponse(ResponseResult::FAIL_PARAM_ILLEGAL);
        }
        switch ($fileType) {
            case "1":
                $checkRes = $this->fileService->checkFile($uploadFileObj, "img");
                if ($checkRes !== true) {
                    return ResponseResult::getResponse($checkRes);
                }
                break;
            case "2":
                $checkRes = $this->fileService->checkFile($uploadFileObj, "doc");
                if ($checkRes !== true) {
                    return ResponseResult::getResponse($checkRes);
                }
                break;
            case "3":
                $checkRes = $this->fileService->checkFile($uploadFileObj, "voice");
                if ($checkRes !== true) {
                    return ResponseResult::getResponse($checkRes);
                }
                break;
            case "4":
                $checkRes = $this->fileService->checkFile($uploadFileObj, "video");
                if ($checkRes !== true) {
                    return ResponseResult::getResponse($checkRes);
                }
                break;
            default:
                return ResponseResult::getResponse(ResponseResult::FAIL_PARAM_ILLEGAL);
        }
        return $this->storeFile($uploadFileObj, $fileType);
    }

    /**
     * 保存图片到服务器
     * @param \Illuminate\Http\UploadedFile $uploadFileObj
     * @param $type 1|img 2|doc 3|voice 4|video
     * @return array
     */
    public function storeFile($uploadFileObj, $type)
    {
        //保存文件
        //重新生成保存的文件名
        $noExtName = substr($uploadFileObj->getClientOriginalName(), 0, strrpos($uploadFileObj->getClientOriginalName(), '.'));
        $newFilename = FileService::getUniqueFilename($noExtName) . "." . FileService::getFileExt($uploadFileObj->getClientOriginalName());
        $saveRes = $uploadFileObj->storeAs(File::$pathMap[$type], $newFilename);
        $code = $saveRes === false ? ResponseResult::FAIL_COM : ResponseResult::SUCCESS_COM;
        if ($saveRes) {
            //记录上传成功的图片信息到redis
            $statRes = $this->fileCache->statUpload(Auth::user()->id, "img");
        }
        //获取上传后的文件url
        $imgUrl = Storage::url($saveRes);
        $result = [
            'src' => $imgUrl,
            'size' => $uploadFileObj->getSize(),
            'newName' => $saveRes
        ];
        return ResponseResult::getResponse($code, '', $result);
    }

    /**
     * 删除文件
     * @param Request $request
     * @return array
     */
    public function removeFile(Request $request)
    {
        $file = $request->get("filename");
        $fileType =$request->get("fileType");
        if (!isset(File::$pathMap[$fileType])) {
            return ResponseResult::getResponse(ResponseResult::FAIL_PARAM_ILLEGAL);
        }
        $filename = $file;
        $delRes = Storage::delete($filename);
        $code = $delRes === true ? ResponseResult::SUCCESS_COM : ResponseResult::FAIL_SERVICE_DEL;
        return ResponseResult::getResponse($code);
    }

    /**
     * 获取brand图片
     * @return array
     */
    public function getNav()
    {
        $result = [
            'error_code' => 0,
            'error_msg' => 'success',
            'result' => asset("imgs/brand.png")
        ];
        return $result;
    }
}