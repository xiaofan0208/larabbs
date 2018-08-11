<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Category ; 
use Auth;
use App\Handlers\ImageUploadHandler ;
use App\Models\User;

class TopicsController extends Controller
{
    public function __construct()
    {
		// 限制未登录用户发帖
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request , Topic  $topic ,User $user )
	{
	//	$topics = Topic::with('user','category')->paginate(30);
		$topics = $topic->withOrder($request->order )->paginate(20);

		$active_users = $user->getActiveUsers();

		return view('topics.index', compact('topics','active_users'));
	}

    public function show( Request $request , Topic $topic)
    {
		 // URL 矫正 ( 如果请求过来url的slug后缀 和 数据库中的不一致，则重定向到正确的url上 )
		if( !empty( $topic->slug ) && $topic->slug !=  $request->slug  ){
			return redirect( $topic->link() , 301 );
		}

        return view('topics.show', compact('topic'));
    }

	// 发帖页面
	public function create(Topic $topic)
	{
		// 创建帖子时可以 选择分类
		$categories = Category::all() ; 
		return view('topics.create_and_edit', compact('topic' , 'categories'));
	}

	// 创建帖子后的处理 ( 请求先经过 TopicRequest 验证)
	public function store(TopicRequest $request , Topic $topic )
	{
		$topic->fill(  $request->all() );
		$topic->user_id = Auth::id();
		$topic->save() ;
	//	$topic = Topic::create($request->all());
	//	return redirect()->route('topics.show', $topic->id)->with('message', '成功创建话题！');

		return redirect()->to( $topic->link() )->with('message', '成功创建话题！');
	}

	// 编辑 
	public function edit(Topic $topic)
	{
		$this->authorize('update', $topic);
		$categories = Category::all() ; 
		return view('topics.create_and_edit', compact('topic','categories'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

	//	return redirect()->route('topics.show', $topic->id)->with('message', '更新成功！');
		return redirect()->to( $topic->link() )->with('message', '更新成功！');
	}
	// 删除 帖子
	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', '成功删除！');
	}

	// 上传图片
	public function uploadImage(Request $request , ImageUploadHandler $uploader)
	{
		// 初始化返回数据，默认是失败的
		$data = [
			'success'   => false,
			'msg'       => '上传失败!',
			'file_path' => ''
		];
		  // 判断是否有上传文件，并赋值给 $file
		if( $file = $request->upload_file){
			 // 保存图片到本地
			$result = $uploader->save( $request->upload_file , 'topics' , \Auth::id() , 1024);
			  // 图片保存成功的话
			if( $result ){
				$data['file_path'] = $result['path'];
				$data['msg']       = "上传成功!";
                $data['success']   = true;
			}
		}
		return $data;
	}
}