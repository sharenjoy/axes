<?php

namespace App\Http\Controllers;

use Image, Categorize;
use Illuminate\Http\Request;
use App\Modules\Tag\TagInterface;
use App\Modules\Post\PostInterface;
use App\Modules\Chain\ChainInterface;
use App\Modules\Display\DisplayInterface;
use App\Modules\Product\ProductInterface;
use App\Modules\Carousel\CarouselInterface;
use App\Http\Controllers\FrontCommonController;

class HomeController extends FrontCommonController {

	public function __construct()
	{
		parent::__construct();
	}

	public function index(CarouselInterface $carouselRepo, PostInterface $newsRepo)
	{
		$carousel = $carouselRepo->showByWhere('status_id', 1);

		$news = $newsRepo->showByAmount(3);

		return $this->layout()->with('carousel', $carousel)->with('news', $news->toArray());
	}

	public function about()
	{
		return $this->layout();
	}

	public function news(PostInterface $repo, TagInterface $tagRepo, Request $request)
	{
		$model = $repo->makeFrontendQuery();

		if ($request->has('tag')) {
			$tag = $request->input('tag');
	        $model = $model->withAnyTag($tag);
		}

        $model = $repo->filter(['status'=>'1'], $model)->where('published_at', '<=', date('Y-m-d'));

		$result = $repo->showByPage(10, null, $model);

		$result->setPath('news');

		$lastestNews = $repo->showByAmount(5);

		$tags = $tagRepo->showByWhere('type', 'news');

		return $this->layout()->with('news', $result)->with('lastestnews', $lastestNews)->with('tags', $tags);
	}

	public function newsDetail($id, PostInterface $repo, TagInterface $tagRepo)
	{
		$news = $repo->with(['tags', 'album.files'])->showById($id);

		$newsItem = $repo->getModel()->whereStatusId('1')->where('published_at', '<=', date('Y-m-d'))->orderBy('published_at', 'desc')->orderBy('sort', 'desc')->get()->toArray();

		$next = null;
		$previous = null;
		foreach ($newsItem as $key => $item) {
			if ($item['id'] == $id) {
				if (isset($newsItem[$key+1])) {
					$next = $newsItem[$key+1];
				}
				if ($key !== 0 && isset($newsItem[$key-1])) {
					$previous = $newsItem[$key-1];
				}
				break;
			}
		}

        $lastestNews = $repo->showByAmount(5);

		$tags = $tagRepo->showByWhere('type', 'news');

		return $this->layout()->with('item', $news)->with('lastestnews', $lastestNews)->with('tags', $tags)->with('next', $next)->with('previous', $previous);
	}

	public function product(ProductInterface $repo, TagInterface $tagRepo)
	{
		$result = $repo->with('tags')->showByWhere('status_id', '1');

		$tags = $tagRepo->showByWhere('type', 'product');

		return $this->layout()->with('products', $result)->with('tags', $tags);
	}
	
	public function productDetail($id, ProductInterface $repo)
	{
		$product = $repo->showById($id);

		$proItem = $repo->getModel()->whereStatusId('1')->orderBy('sort', 'desc')->get()->toArray();

		$next = null;
		$previous = null;
		foreach ($proItem as $key => $item) {
			if ($item['id'] == $id) {
				if (isset($proItem[$key+1])) {
					$next = $proItem[$key+1];
				}
				if ($key !== 0 && isset($proItem[$key-1])) {
					$previous = $proItem[$key-1];
				}
				break;
			}
		}

		$tags = $product->tags->implode('tag', ',');

		$accessories = $product->with(['album.files', 'tags'])->withAnyTag($tags)->whereNotIn('id', [$product->id])->inRandomOrder()->limit(3)->get()->toArray();

		return $this->layout()->with('item', $product)->with('accessories', $accessories)->with('next', $next)->with('previous', $previous);
	}

	public function whereToBuy(DisplayInterface $displayRepo, ChainInterface $chainRepo)
	{
		$displays = $displayRepo->showByWhere('status_id', '1');

		$chains = $chainRepo->showByWhere('status_id', '1');

		return $this->layout()->with('displays', $displays)->with('chains', $chains);
	}

	public function contactUs(Request $request)
	{
		$data = $request->input('data');

		$email = explode(',', \Setting::get('admin_email'));

		\Mail::queue('emails.contact', $data, function($message) use ($email)
		{
		    $message->from(config('mail.from.address'), config('mail.from.name'))
		            ->subject('TESCOM聯絡我們表單');

		    $message->to($email);
		});

		message()->success('您的訊息已寄出！');

		return redirect('wheretobuy');
	}

	public function downloadFile($filename)
	{
		$file = \DB::table('files')->select('name', 'extension')
                                     ->where('filename', $filename)
                                     ->first();

		return response()->download(public_path().'/uploads/'.$filename.'.'.$file->extension, "$file->name.$file->extension");
	}

	public function search(Request $request, PostInterface $newsRepo, ProductInterface $proRepo)
	{
		$keyword = $request->input('keyword');

		if ($request->input('searchType') == 'news') {
			$result = $newsRepo->getModel()->where(function ($query) use ($keyword) {
				$query->where('summary', 'like', "%$keyword%")
					  ->orWhere('title', 'like', "%$keyword%")
					  ->orWhere('content', 'like', "%$keyword%");
			})->where('status_id', 1)->orderBy('sort', 'desc')->get();
		} else {
			$result = $proRepo->getModel()->where(function ($query) use ($keyword) {
				$query->where('summary', 'like', "%$keyword%")
					  ->orWhere('title', 'like', "%$keyword%")
					  ->orWhere('content_one', 'like', "%$keyword%")
					  ->orWhere('content_two', 'like', "%$keyword%");
			})->where('status_id', 1)->orderBy('sort', 'desc')->get();
		}

		return view('search')->with('result', $result);
	}

}
