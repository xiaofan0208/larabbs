<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Category ; 
use Auth;

class TopicsController extends Controller
{
    public function __construct()
    {
		// 限制未登录用户发帖
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

	public function index(Request $request , Topic  $topic )
	{
	//	$topics = Topic::with('user','category')->paginate(30);
		$topics = $topic->withOrder($request->order )->paginate(20);
		return view('topics.index', compact('topics'));
	}

    public function show(Topic $topic)
    {
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
		return redirect()->route('topics.show', $topic->id)->with('message', 'Created successfully.');
	}

	public function edit(Topic $topic)
	{
        $this->authorize('update', $topic);
		return view('topics.create_and_edit', compact('topic'));
	}

	public function update(TopicRequest $request, Topic $topic)
	{
		$this->authorize('update', $topic);
		$topic->update($request->all());

		return redirect()->route('topics.show', $topic->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Topic $topic)
	{
		$this->authorize('destroy', $topic);
		$topic->delete();

		return redirect()->route('topics.index')->with('message', 'Deleted successfully.');
	}
}