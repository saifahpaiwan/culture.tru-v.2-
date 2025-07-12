<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\activitys;
use App\Models\pages;
use App\Models\news;
use App\Models\books;
use App\Models\menu_mg;
use App\Models\slideshow;
use App\Models\popups;
use App\Models\journals;
use App\Models\researchs;
use App\Models\acticonservation;
use App\Models\culturehall_gallerys;
use App\Models\culturehalls;
use App\Models\journal_gallerys;
use App\Models\learning;
use App\Models\learning_gallerys;
use App\Models\learning_types;
use App\Models\network_gallerys;
use App\Models\networks;
use App\Models\qualitie_gallerys;
use App\Models\reportannuals;
use App\Models\qualities;
use App\Models\reportannual_gallerys;
use App\Models\studies;
use App\Models\study_gallerys;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        $data = array(
            "Query_slideshow" => slideshow::where('deleted_at', 0)->orderBy('id', 'desc')->get(),
            "Query_popups" => popups::where('deleted_at', 0)->orderBy('id', 'desc')->get(),
            "Query_news" => news::where('deleted_at', 0)->orderBy('id', 'desc')->limit(4)->get(),
            "Query_journal" => journals::where('deleted_at', 0)->orderBy('id', 'desc')->limit(5)->get(),
            "Query_activity" => activitys::where('deleted_at', 0)->orderBy('id', 'desc')->limit(10)->get(),
            "Query_books" => books::where('deleted_at', 0)->orderBy('id', 'desc')->limit(4)->get(),
            "Query_research" => researchs::where('deleted_at', 0)->orderBy('id', 'desc')->limit(4)->get(),

            "bg_detail" => asset('images/bg_detail.jpg'),
        );
        return view('frontend.index', compact('data'));
    }

    public function newslist()
    {
        $search = (isset($_GET['search']) && !empty($_GET['search'])) ? $_GET['search'] : null;
        $year = (isset($_GET['year']) && !empty($_GET['year'])) ? $_GET['year'] : null;

        $queryNews = news::query();
        $queryNews->where('deleted_at', 0);

        if (!empty($search)) {
            $queryNews->where('news_title', 'like', '%' . $search . '%')
                ->orWhere('news_intro', 'like', '%' . $search . '%');
        }

        if (!empty($year)) {
            $from = ($year - 543) . '-01-01';
            $to = ($year - 543) . '-12-31';
            $queryNews->whereBetween('news_date', [$from, $to]);
        }

        $result = $queryNews->orderBy('id', 'desc')->paginate(9);

        $data = array(
            "Query_news" => $result,
            "search" => $search,
            "year" => $year,
        );
        return view('frontend.newslist', compact('data'));
    }

    public function news($get_id)
    {
        $result = news::where('id', $get_id)->where('deleted_at', 0)->first();
        $this->countViewNews($result);
        $data = array(
            "get_id" => $get_id,
            "result_news" => $result,
            "gallerys"    => DB::table('news_gallerys')->where('news_id', $get_id)->get(),
            "Query_news" => news::where('deleted_at', 0)->inRandomOrder()->orderBy('id', 'desc')->limit(10)->get(),
        );
        return view('frontend.news', compact('data'));
    }

    function countViewNews($result)
    {
        $viewed = [];
        $user_ip = request()->ip();
        if (!Session::get('user_viewed_ip') || !empty(Session::get('user_viewed_ip'))) {

            $userViewedIP = Session::get('user_viewed_ip');
            $viewed = $userViewedIP;
            if (!isset($userViewedIP[$user_ip]['news'][$result->id]['id'])) {
                $num = $result->count_view + 1;
                news::where('id', $result->id)->update([
                    'count_view' => $num,
                ]);

                $viewed[$user_ip]['news'][$result->id]['id']      = $result->id;
                $viewed[$user_ip]['news'][$result->id]['user_ip'] = $user_ip;
                Session::put('user_viewed_ip', $viewed);
            }
        }
    }

    public function activitylist()
    {
        $search = (isset($_GET['search']) && !empty($_GET['search'])) ? $_GET['search'] : null;
        $year = (isset($_GET['year']) && !empty($_GET['year'])) ? $_GET['year'] : null;

        $query = activitys::query();
        $query->where('deleted_at', 0);

        if (!empty($search)) {
            $query->where('activity_title', 'like', '%' . $search . '%')
                ->orWhere('activity_intro', 'like', '%' . $search . '%');
        }

        if (!empty($year)) {
            $query->where('year', $year);
        }

        if (!empty($year)) {
            $from = ($year - 543) . '-01-01';
            $to = ($year - 543) . '-12-31';
            $query->whereBetween('activity_date', [$from, $to]);
        }

        $result = $query->orderBy('id', 'desc')->paginate(9);

        $data = array(
            "Query_activitys" => $result,
            "search" => $search,
            "year" => $year,
        );
        return view('frontend.activitylist', compact('data'));
    }

    public function activity($get_id)
    {
        $result = activitys::where('id', $get_id)->where('deleted_at', 0)->first();
        $this->countViewActivitys($result);
        $data = array(
            "get_id" => $get_id,
            "result_activitys" => $result,
            "gallerys"    => DB::table('activity_gallerys')->where('activity_id', $get_id)->get(),
            "Query_activitys" => activitys::where('deleted_at', 0)->inRandomOrder()->orderBy('id', 'desc')->limit(10)->get(),
        );
        return view('frontend.activity', compact('data'));
    }

    function countViewActivitys($result)
    {
        $viewed = [];
        $user_ip = request()->ip();
        if (!Session::get('user_viewed_ip') || !empty(Session::get('user_viewed_ip'))) {

            $userViewedIP = Session::get('user_viewed_ip');
            $viewed = $userViewedIP;
            if (!isset($userViewedIP[$user_ip]['activitys'][$result->id]['id'])) {
                $num = $result->count_view + 1;
                activitys::where('id', $result->id)->update([
                    'count_view' => $num,
                ]);

                $viewed[$user_ip]['activitys'][$result->id]['id']      = $result->id;
                $viewed[$user_ip]['activitys'][$result->id]['user_ip'] = $user_ip;
                Session::put('user_viewed_ip', $viewed);
            }
        }
    }

    public function journalslist()
    {
        $search = (isset($_GET['search']) && !empty($_GET['search'])) ? $_GET['search'] : null;
        $month = (isset($_GET['month']) && !empty($_GET['month'])) ? $_GET['month'] : null;

        $query = journals::query();
        $query->where('deleted_at', 0);

        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('intro', 'like', '%' . $search . '%');
        }

        if (!empty($month)) {
            $from = $month . '-01';
            $to   = $month . '-31';
            $query->whereBetween('month', [$from, $to]);
        }

        $result = $query->orderBy('id', 'desc')->paginate(9);

        $data = array(
            "Query_journals" => $result,
            "search" => $search,
            "month" => $month,
        );
        return view('frontend.journalslist', compact('data'));
    }

    public function journals($get_id)
    {
        $result = journals::where('id', $get_id)->where('deleted_at', 0)->first();
        $this->countViewJournals($result);
        $data = array(
            "get_id" => $get_id,
            "result_journals" => $result,
            "gallerys"    => journal_gallerys::where('journal_id', $get_id)->get(),
            "Query_journals" => journals::where('deleted_at', 0)->inRandomOrder()->orderBy('id', 'desc')->limit(10)->get(),
        );
        return view('frontend.journals', compact('data'));
    }

    function countViewJournals($result)
    {
        $viewed = [];
        $user_ip = request()->ip();
        if (!Session::get('user_viewed_ip') || !empty(Session::get('user_viewed_ip'))) {

            $userViewedIP = Session::get('user_viewed_ip');
            $viewed = $userViewedIP;
            if (!isset($userViewedIP[$user_ip]['journals'][$result->id]['id'])) {
                $num = $result->count_view + 1;
                journals::where('id', $result->id)->update([
                    'count_view' => $num,
                ]);

                $viewed[$user_ip]['journals'][$result->id]['id']      = $result->id;
                $viewed[$user_ip]['journals'][$result->id]['user_ip'] = $user_ip;
                Session::put('user_viewed_ip', $viewed);
            }
        }
    }

    public function bookslist()
    {
        $search = (isset($_GET['search']) && !empty($_GET['search'])) ? $_GET['search'] : null;
        $year = (isset($_GET['year']) && !empty($_GET['year'])) ? $_GET['year'] : null;

        $query = books::query();
        $query->where('deleted_at', 0);

        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('keyword', 'like', '%' . $search . '%')
                ->orWhere('published', 'like', '%' . $search . '%')
                ->orWhere('type', 'like', '%' . $search . '%');
        }

        if (!empty($year)) {
            $query->where('year', $year);
        }

        $result = $query->orderBy('id', 'desc')->paginate(9);

        $data = array(
            "Query_books" => $result,
            "search" => $search,
            "year" => $year,
        );
        return view('frontend.bookslist', compact('data'));
    }

    public function books($get_id)
    {
        $result = books::where('id', $get_id)->where('deleted_at', 0)->first();
        $this->countViewBooks($result);
        $data = array(
            "get_id" => $get_id,
            "result_books" => $result,
            "gallerys"    => DB::table('book_gallerys')->where('book_id', $get_id)->get(),
            "Query_books" => books::where('deleted_at', 0)->inRandomOrder()->orderBy('id', 'desc')->limit(10)->get(),
        );
        return view('frontend.books', compact('data'));
    }

    function countViewBooks($result)
    {
        $viewed = [];
        $user_ip = request()->ip();
        if (!Session::get('user_viewed_ip') || !empty(Session::get('user_viewed_ip'))) {

            $userViewedIP = Session::get('user_viewed_ip');
            $viewed = $userViewedIP;
            if (!isset($userViewedIP[$user_ip]['books'][$result->id]['id'])) {
                $num = $result->count_view + 1;
                books::where('id', $result->id)->update([
                    'count_view' => $num,
                ]);

                $viewed[$user_ip]['books'][$result->id]['id']      = $result->id;
                $viewed[$user_ip]['books'][$result->id]['user_ip'] = $user_ip;
                Session::put('user_viewed_ip', $viewed);
            }
        }
    }

    public function researchslist()
    {
        $search = (isset($_GET['search']) && !empty($_GET['search'])) ? $_GET['search'] : null;
        $year = (isset($_GET['year']) && !empty($_GET['year'])) ? $_GET['year'] : null;

        $query = researchs::query();
        $query->where('deleted_at', 0);

        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('keyword', 'like', '%' . $search . '%')
                ->orWhere('published', 'like', '%' . $search . '%')
                ->orWhere('type', 'like', '%' . $search . '%');
        }

        if (!empty($year)) {
            $query->where('year', $year);
        }

        $result = $query->orderBy('id', 'desc')->paginate(9);

        $data = array(
            "Query_researchs" => $result,
            "search" => $search,
            "year" => $year,
        );
        return view('frontend.researchslist', compact('data'));
    }

    public function researchs($get_id)
    {
        $result = researchs::where('id', $get_id)->where('deleted_at', 0)->first();
        $this->countViewActivitys($result);
        $data = array(
            "get_id" => $get_id,
            "result_researchs" => $result,
            "gallerys"    => DB::table('research_gallerys')->where('research_id', $get_id)->get(),
            "Query_researchs" => researchs::where('deleted_at', 0)->inRandomOrder()->orderBy('id', 'desc')->limit(10)->get(),
        );
        return view('frontend.researchs', compact('data'));
    }

    function countViewResearchs($result)
    {
        $viewed = [];
        $user_ip = request()->ip();
        if (!Session::get('user_viewed_ip') || !empty(Session::get('user_viewed_ip'))) {

            $userViewedIP = Session::get('user_viewed_ip');
            $viewed = $userViewedIP;
            if (!isset($userViewedIP[$user_ip]['researchs'][$result->id]['id'])) {
                $num = $result->count_view + 1;
                researchs::where('id', $result->id)->update([
                    'count_view' => $num,
                ]);

                $viewed[$user_ip]['researchs'][$result->id]['id']      = $result->id;
                $viewed[$user_ip]['researchs'][$result->id]['user_ip'] = $user_ip;
                Session::put('user_viewed_ip', $viewed);
            }
        }
    }

    public function acticonservationslist()
    {
        $search = (isset($_GET['search']) && !empty($_GET['search'])) ? $_GET['search'] : null;
        $year = (isset($_GET['year']) && !empty($_GET['year'])) ? $_GET['year'] : null;

        $query = acticonservation::query();
        $query->where('deleted_at', 0);

        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('intro', 'like', '%' . $search . '%');
        }

        if (!empty($year)) {
            $from = ($year - 543) . '-01-01';
            $to = ($year - 543) . '-12-31';
            $query->whereBetween('date', [$from, $to]);
        }

        $result = $query->orderBy('id', 'desc')->paginate(9);

        $data = array(
            "Query_acticonservations" => $result,
            "search" => $search,
            "year" => $year,
        );
        return view('frontend.acticonservationslist', compact('data'));
    }

    public function acticonservations($get_id)
    {
        $result = acticonservation::where('id', $get_id)->where('deleted_at', 0)->first();
        $this->countViewActiconservations($result);
        $data = array(
            "get_id" => $get_id,
            "result_acticonservations" => $result,
            "gallerys"   => DB::table('acticonservation_gallerys')->where('acticonservation_id', $get_id)->get(),
            "Query_acticonservations" => acticonservation::where('deleted_at', 0)->inRandomOrder()->orderBy('id', 'desc')->limit(10)->get(),
        );
        return view('frontend.acticonservations', compact('data'));
    }

    function countViewActiconservations($result)
    {
        $viewed = [];
        $user_ip = request()->ip();
        if (!Session::get('user_viewed_ip') || !empty(Session::get('user_viewed_ip'))) {

            $userViewedIP = Session::get('user_viewed_ip');
            $viewed = $userViewedIP;
            if (!isset($userViewedIP[$user_ip]['acticonservation'][$result->id]['id'])) {
                $num = $result->count_view + 1;
                acticonservation::where('id', $result->id)->update([
                    'count_view' => $num,
                ]);

                $viewed[$user_ip]['acticonservation'][$result->id]['id']      = $result->id;
                $viewed[$user_ip]['acticonservation'][$result->id]['user_ip'] = $user_ip;
                Session::put('user_viewed_ip', $viewed);
            }
        }
    }

    public function learningslist()
    {
        $search = (isset($_GET['search']) && !empty($_GET['search'])) ? $_GET['search'] : null;
        $year = (isset($_GET['year']) && !empty($_GET['year'])) ? $_GET['year'] : null;
        $type = (isset($_GET['type']) && !empty($_GET['type'])) ? $_GET['type'] : null;

        $query = learning::query();
        $query->where('deleted_at', 0);

        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('keyword', 'like', '%' . $search . '%')
                ->orWhere('published', 'like', '%' . $search . '%')
                ->orWhere('type', 'like', '%' . $search . '%');
        }

        if (!empty($year)) {
            $query->where('year', $year);
        }

        $result = $query->orderBy('id', 'desc')->paginate(9);

        $data = array(
            "Query_learnings" => $result,
            "Query_learningsType" => learning_types::where('deleted_at', 0)->orderBy('id', 'asc')->get(),
            "search" => $search,
            "year" => $year,
        );
        return view('frontend.learningslist', compact('data'));
    }

    public function learnings($get_id)
    {
        $result = learning::where('id', $get_id)->where('deleted_at', 0)->first();
        $this->countViewLearnings($result);
        $data = array(
            "get_id" => $get_id,
            "result_learnings" => $result,
            "gallerys"    => learning_gallerys::where('learning_id', $get_id)->get(),
            "Query_learnings" => learning::where('deleted_at', 0)->inRandomOrder()->orderBy('id', 'desc')->limit(10)->get(),
        );
        return view('frontend.learnings', compact('data'));
    }

    function countViewLearnings($result)
    {
        $viewed = [];
        $user_ip = request()->ip();
        if (!Session::get('user_viewed_ip') || !empty(Session::get('user_viewed_ip'))) {

            $userViewedIP = Session::get('user_viewed_ip');
            $viewed = $userViewedIP;
            if (!isset($userViewedIP[$user_ip]['learning'][$result->id]['id'])) {
                $num = $result->count_view + 1;
                learning::where('id', $result->id)->update([
                    'count_view' => $num,
                ]);

                $viewed[$user_ip]['learning'][$result->id]['id']      = $result->id;
                $viewed[$user_ip]['learning'][$result->id]['user_ip'] = $user_ip;
                Session::put('user_viewed_ip', $viewed);
            }
        }
    }

    public function networkslist()
    {
        $search = (isset($_GET['search']) && !empty($_GET['search'])) ? $_GET['search'] : null;
        $year = (isset($_GET['year']) && !empty($_GET['year'])) ? $_GET['year'] : null;

        $query = networks::query();
        $query->where('deleted_at', 0);

        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('intro', 'like', '%' . $search . '%');
        }

        if (!empty($year)) {
            $from = ($year - 543) . '-01-01';
            $to = ($year - 543) . '-12-31';
            $query->whereBetween('date', [$from, $to]);
        }

        $result = $query->orderBy('id', 'desc')->paginate(9);

        $data = array(
            "Query_networks" => $result,
            "search" => $search,
            "year" => $year,
        );
        return view('frontend.networkslist', compact('data'));
    }

    public function networks($get_id)
    {
        $result = networks::where('id', $get_id)->where('deleted_at', 0)->first();
        $this->countViewNetworks($result);
        $data = array(
            "get_id" => $get_id,
            "result_networks" => $result,
            "gallerys"    => network_gallerys::where('network_id', $get_id)->get(),
            "Query_networks" => networks::where('deleted_at', 0)->inRandomOrder()->orderBy('id', 'desc')->limit(10)->get(),
        );
        return view('frontend.networks', compact('data'));
    }

    function countViewNetworks($result)
    {
        $viewed = [];
        $user_ip = request()->ip();
        if (!Session::get('user_viewed_ip') || !empty(Session::get('user_viewed_ip'))) {

            $userViewedIP = Session::get('user_viewed_ip');
            $viewed = $userViewedIP;
            if (!isset($userViewedIP[$user_ip]['networks'][$result->id]['id'])) {
                $num = $result->count_view + 1;
                networks::where('id', $result->id)->update([
                    'count_view' => $num,
                ]);

                $viewed[$user_ip]['networks'][$result->id]['id']      = $result->id;
                $viewed[$user_ip]['networks'][$result->id]['user_ip'] = $user_ip;
                Session::put('user_viewed_ip', $viewed);
            }
        }
    }

    public function reportannualslist()
    {
        $search = (isset($_GET['search']) && !empty($_GET['search'])) ? $_GET['search'] : null;
        $year = (isset($_GET['year']) && !empty($_GET['year'])) ? $_GET['year'] : null;

        $query = reportannuals::query();
        $query->where('deleted_at', 0);

        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('intro', 'like', '%' . $search . '%');
        }

        if (!empty($year)) {
            $query->where('year', $year);
        }

        if (!empty($year)) {
            $from = ($year - 543) . '-01-01';
            $to = ($year - 543) . '-12-31';
            $query->whereBetween('date', [$from, $to]);
        }

        $result = $query->orderBy('id', 'desc')->paginate(9);

        $data = array(
            "Query_reportannuals" => $result,
            "search" => $search,
            "year" => $year,
        );
        return view('frontend.reportannualslist', compact('data'));
    }

    public function reportannuals($get_id)
    {
        $result = reportannuals::where('id', $get_id)->where('deleted_at', 0)->first();
        $this->countViewReportannuals($result);
        $data = array(
            "get_id" => $get_id,
            "result_reportannuals" => $result,
            "gallerys"    => reportannual_gallerys::where('reportannual_id', $get_id)->get(),
            "Query_reportannuals" => reportannuals::where('deleted_at', 0)->inRandomOrder()->orderBy('id', 'desc')->limit(10)->get(),
        );
        return view('frontend.reportannuals', compact('data'));
    }

    function countViewReportannuals($result)
    {
        $viewed = [];
        $user_ip = request()->ip();
        if (!Session::get('user_viewed_ip') || !empty(Session::get('user_viewed_ip'))) {

            $userViewedIP = Session::get('user_viewed_ip');
            $viewed = $userViewedIP;
            if (!isset($userViewedIP[$user_ip]['reportannuals'][$result->id]['id'])) {
                $num = $result->count_view + 1;
                reportannuals::where('id', $result->id)->update([
                    'count_view' => $num,
                ]);

                $viewed[$user_ip]['reportannuals'][$result->id]['id']      = $result->id;
                $viewed[$user_ip]['reportannuals'][$result->id]['user_ip'] = $user_ip;
                Session::put('user_viewed_ip', $viewed);
            }
        }
    }

    public function qualitieslist()
    {
        $search = (isset($_GET['search']) && !empty($_GET['search'])) ? $_GET['search'] : null;
        $month = (isset($_GET['month']) && !empty($_GET['month'])) ? $_GET['month'] : null;

        $query = qualities::query();
        $query->where('deleted_at', 0);

        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('intro', 'like', '%' . $search . '%');
        }

        if (!empty($year)) {
            $query->where('year', $year);
        }

        if (!empty($month)) {
            $from = $month . '-01';
            $to = $month . '-31';
            $query->whereBetween('date', [$from, $to]);
        }

        $result = $query->orderBy('id', 'desc')->paginate(9);

        $data = array(
            "Query_qualities" => $result,
            "search" => $search,
            "month" => $month,
        );
        return view('frontend.qualitieslist', compact('data'));
    }

    public function qualities($get_id)
    {
        $result = qualities::where('id', $get_id)->where('deleted_at', 0)->first();
        $this->countViewQualities($result);
        $data = array(
            "get_id" => $get_id,
            "result_qualities" => $result,
            "gallerys"    => qualitie_gallerys::where('qualitie_id', $get_id)->get(),
            "Query_qualities" => qualities::where('deleted_at', 0)->inRandomOrder()->orderBy('id', 'desc')->limit(10)->get(),
        );
        return view('frontend.qualities', compact('data'));
    }

    function countViewQualities($result)
    {
        $viewed = [];
        $user_ip = request()->ip();
        if (!Session::get('user_viewed_ip') || !empty(Session::get('user_viewed_ip'))) {

            $userViewedIP = Session::get('user_viewed_ip');
            $viewed = $userViewedIP;
            if (!isset($userViewedIP[$user_ip]['qualities'][$result->id]['id'])) {
                $num = $result->count_view + 1;
                qualities::where('id', $result->id)->update([
                    'count_view' => $num,
                ]);

                $viewed[$user_ip]['qualities'][$result->id]['id']      = $result->id;
                $viewed[$user_ip]['qualities'][$result->id]['user_ip'] = $user_ip;
                Session::put('user_viewed_ip', $viewed);
            }
        }
    }

    // ********************* //
    public function page($get_id)
    {
        $data = array(
            "get_id" => $get_id,
            "result_page" => pages::where('id', $get_id)->where('deleted_at', 0)->first(),
            "gallerys"    => DB::table('page_gallerys')->where('page_id', $get_id)->get(),
        );
        return view('frontend.page', compact('data'));
    }

    public function Ordermenu()
    {
        $row = menu_mg::where('id', 1)->first();
        $arr = (isset($row)) ? json_decode($row->list) : null;
        $itmes = [];
        if (!empty($arr)) {
            foreach ($arr as $key => $row) {
                $Qry1 = DB::table('menus')->where('id', $row->id)->first();
                $itmes[$key]['id'] = $Qry1->id;
                $itmes[$key]['name'] = $Qry1->name;
                $itmes[$key]['link'] = $Qry1->slug;
                if (isset($row->children) && count($row->children) > 0) {
                    foreach ($row->children as $key2 => $row2) {
                        $Qry2 = DB::table('menus')->where('id', $row2->id)->first();
                        $itmes[$key]['children'][$key2]['id'] = $Qry2->id;
                        $itmes[$key]['children'][$key2]['name'] = $Qry2->name;
                        $itmes[$key]['children'][$key2]['link'] = $Qry2->slug;
                    }
                }
            }
        }
        return $itmes;
    }

    public function appeals()
    {

        $data = array();
        return view('frontend.appeals', compact('data'));
    }

    public function saveappeals(Request $request)
    {
        if (isset($request)) {
            $request->validate(
                [
                    'name' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255'],
                    'topic' => ['required', 'string', 'max:255'],
                    'description' => ['required', 'string'],
                ]
            );

            $data = array(
                "name" => $request->name,
                "email" => $request->email,
                "topic" => $request->topic,
                "description" => $request->description,

                'ip_address' => $request->ip(),
                'created_at'    => new \DateTime(),
            );

            if (DB::table('appeals')->insert($data)) {
                return redirect()->route('appeals')->with('success', "ส่งคำร้องเรียนร้องทุกข์เรียบร้อยแล้ว.");
            }
        }
    }

    public function studylist()
    {
        $search = (isset($_GET['search']) && !empty($_GET['search'])) ? $_GET['search'] : null;
        $year = (isset($_GET['year']) && !empty($_GET['year'])) ? $_GET['year'] : null;

        $query = studies::query();
        $query->where('deleted_at', 0);

        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('intro', 'like', '%' . $search . '%');
        }

        if (!empty($year)) {
            $from = ($year - 543) . '-01-01';
            $to = ($year - 543) . '-12-31';
            $query->whereBetween('date', [$from, $to]);
        }

        $result = $query->orderBy('id', 'desc')->paginate(9);

        $data = array(
            "Query_study" => $result,
            "search" => $search,
            "year" => $year,
        );
        return view('frontend.studylist', compact('data'));
    }

    public function study($get_id)
    {
        $result = studies::where('id', $get_id)->where('deleted_at', 0)->first();
        $this->countViewStudy($result);
        $data = array(
            "get_id" => $get_id,
            "result_study" => $result,
            "gallerys"    => study_gallerys::where('study_id', $get_id)->get(),
            "Query_study" => studies::where('deleted_at', 0)->inRandomOrder()->orderBy('id', 'desc')->limit(10)->get(),
        );
        return view('frontend.study', compact('data'));
    }

    function countViewStudy($result)
    {
        $viewed = [];
        $user_ip = request()->ip();
        if (!Session::get('user_viewed_ip') || !empty(Session::get('user_viewed_ip'))) {

            $userViewedIP = Session::get('user_viewed_ip');
            $viewed = $userViewedIP;
            if (!isset($userViewedIP[$user_ip]['qualities'][$result->id]['id'])) {
                $num = $result->count_view + 1;
                qualities::where('id', $result->id)->update([
                    'count_view' => $num,
                ]);

                $viewed[$user_ip]['qualities'][$result->id]['id']      = $result->id;
                $viewed[$user_ip]['qualities'][$result->id]['user_ip'] = $user_ip;
                Session::put('user_viewed_ip', $viewed);
            }
        }
    }

    public function culturehalllist()
    {
        $search = (isset($_GET['search']) && !empty($_GET['search'])) ? $_GET['search'] : null;
        $year = (isset($_GET['year']) && !empty($_GET['year'])) ? $_GET['year'] : null;

        $query = culturehalls::query();
        $query->where('deleted_at', 0);

        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('intro', 'like', '%' . $search . '%');
        }

        if (!empty($year)) {
            $from = ($year - 543) . '-01-01';
            $to = ($year - 543) . '-12-31';
            $query->whereBetween('date', [$from, $to]);
        }

        $result = $query->orderBy('id', 'desc')->paginate(9);

        $data = array(
            "Query_culturehalls" => $result,
            "search" => $search,
            "year" => $year,
        );
        return view('frontend.culturehalllist', compact('data'));
    }

    public function culturehall($get_id)
    { 
        $result = culturehalls::where('id', $get_id)->where('deleted_at', 0)->first();
        $this->countViewCulturehalls($result);
        $data = array(
            "get_id" => $get_id,
            "result_culturehall" => $result,
            "gallerys"    => culturehall_gallerys::where('culturehall_id', $get_id)->get(),
            "Query_culturehall" => culturehalls::where('deleted_at', 0)->inRandomOrder()->orderBy('id', 'desc')->limit(10)->get(),
        );
        return view('frontend.culturehall', compact('data'));
    }

    function countViewCulturehalls($result)
    {
        $viewed = [];
        $user_ip = request()->ip();
        if (!Session::get('user_viewed_ip') || !empty(Session::get('user_viewed_ip'))) {

            $userViewedIP = Session::get('user_viewed_ip');
            $viewed = $userViewedIP;
            if (!isset($userViewedIP[$user_ip]['culturehalls'][$result->id]['id'])) {
                $num = $result->count_view + 1;
                culturehalls::where('id', $result->id)->update([
                    'count_view' => $num,
                ]);

                $viewed[$user_ip]['culturehalls'][$result->id]['id']      = $result->id;
                $viewed[$user_ip]['culturehalls'][$result->id]['user_ip'] = $user_ip;
                Session::put('user_viewed_ip', $viewed);
            }
        }
    }
}
