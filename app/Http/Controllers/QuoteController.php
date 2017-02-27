<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Author;

use App\Quote;

class QuoteController extends Controller
{
    public function getIndex($author = null)
    {
        if (!is_null($author)) {
            $quote_author = Author::where('name',$author)->first();
            if ($quote_author) {
                $quotes = $quote_author->quotes()->orderBy('created_at', 'desc')->paginate(3);
            }
        } else {
         $quotes = Quote::orderBy('created_at','desc')->paginate(3);
        }
        return view('index',['quotes' => $quotes]);
    }

    public function getDeleteQuote($quote_id)
    {
        $quote = Quote::find($quote_id);
        // 判断最后弹出信息
        $author_deleted = false;
        // 获取该作者共有多少引用句
        if( count($quote->author->quotes) == 1) {
            $quote->author->delete();
            $author_deleted = true;
        }
        $quote->delete();

        $msg = $author_deleted ? 'Quote and author deleted!' : 'Quote deleted!';
        return redirect()->route('index')->with([
            'success' => $msg
        ]);
    }

    public function postQuote(Request $request)
    {
        $this->validate($request,[
            'author' => 'required|max:60',
            'quote' => 'required|max:500'
        ]);

        $authorText = ucfirst(strtolower($request->author));
        $quoteText = $request->quote;

        // 查询数据库中是否有该 $authorText
        $author = Author::where('name',$authorText)->first();
        if (!$author) {
            // 存储该author
            $author = new Author();
            $author->name  = $authorText;
            $author->save();
        }
        // 将 $quoteText 存储少quotes
        $quote = new Quote();
        $quote->quote = $quoteText;
        $author->quotes()->save($quote);
        // 链式调用回所保存的session内容 
        return redirect()->route('index')->with([
            'success' => 'Quote saved!'
        ]);
    }
    // 获取用户id形式  完成同样的筛选用户功能 
    public function getProfileAuthor($author_id)
    {
        $quotes = Author::find($author_id)->quotes()->paginate(6);
        return view('index',compact('quotes'));
    }
}
