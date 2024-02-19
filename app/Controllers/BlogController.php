<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SubCategory;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Post;
// use Config\Pager;

class BlogController extends BaseController
{
    protected $helpers = ['url', 'form', 'CIMail', 'CIFunctions', 'text'];

    public function index()
    {
        $data = [
            'tabTitle' => 'Home',
        ];

        return view('frontend/pages/home', $data);
    }

    public function categoryPosts($category_slug)
    {
        $subcat = new SubCategory();
        $subcategory = $subcat->asObject()->where('slug', $category_slug)->first();
        $post = new Post();

        $data = [];
        $data['tabTitle'] = $subcategory->name;
        $data['category'] = $subcategory;
        $data['page'] = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $data['perPage'] = 6;
        $data['total'] = count($post->where('visibility', 1)->where('category_id', $subcategory->id)->findAll());
        $data['posts'] = $post->asObject()->where('visibility', 1)->where('category_id', $subcategory->id)->paginate($data['perPage']);
        $data['pager'] = $post->where('visibility', 1)->where('category_id', $subcategory->id)->pager;

        // $data = [
        //     'tabTitle' => $subcategory->name,
        //     'category' => $subcategory,
        //     'page' => isset($_GET['page']) ? (int) $_GET['page'] : 1,
        //     'perPage' => 6,
        //     'total' => count($post->where('visibility', 1)->where('category_id', $subcategory->id)->findAll()),
        //     'posts' => $post->asObject()->where('visibility', 1)->where('category_id', $subcategory->id)->paginate($data['perPage']),
        //     'pager' => $post->where('visibility', 1)->where('category_id', $subcategory->id)->pager,
        // ];

        return view('frontend/pages/category_posts', $data);
    }

    public function tagPosts($tag)
    {
        $post = new Post();
        $data['tabTitle'] = 'Tag: ' . $tag;
        $data['tag'] = $tag;
        $data['page'] = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $data['perPage'] = 6;
        $data['total'] = count($post->where('visibility', 1)->like('tags', '%' . $tag . '%')->findAll());
        $data['posts'] = $post->asObject()->where('visibility', 1)->like('tags', '%' . $tag . '%')->orderBy('created_at', 'desc')->paginate($data['perPage']);
        $data['pager'] = $post->where('visibility', 1)->like('tags', '%' . $tag . '%')->pager;

        return view('frontend/pages/tag_posts', $data);
    }

    public function searchPosts()
    {
        $request = \Config\Services::request();

        $searchData = $request->getGet();
        $search = isset($searchData) && isset($searchData['q']) ? $searchData['q'] : '';
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $perPage = 6;

        //! Get Data Objek
        $post = new Post();
        //! Get Count Data Objek
        $post2 = new Post();

        if ($search == '') {
            $paginated_data = $post->asObject()->where('visibility', 1)->paginate($perPage);
            $total = $post->where('visibility', 1)->countAllResults();
            $pager = $post->pager;
        } else {
            $keywords = explode(" ", trim($search));
            $post = $this->getSearchData($post, $keywords);
            $post2 = $this->getSearchData($post2, $keywords);

            $paginated_data = $post->asObject()->where('visibility', 1)->paginate($perPage);
            $total = $post->where('visibility', 1)->countAllResults();
            $pager = $post->pager;

            $data = [
                'tabTitle' => 'Search for: ' . $search,
                'posts' => $paginated_data,
                'pager' => $pager,
                'page' => $page,
                'perPage' => $perPage,
                'search' => $search,
                'total' => $total
            ];

            return view('frontend/pages/search_posts', $data);
        }
    }

    public function getSearchData($object, $keywords)
    {
        $object->select('*');
        $object->groupStart();
        foreach ($keywords as $keyword) {
            $object->orLike('title', $keyword)->orLike('tags', $keyword);
        }
        return $object->groupEnd();
    }

    public function readPost($slug)
    {
        $post = new Post();
        try {
            $post = $post->asObject()->where('slug', $slug)->first();
            $data = [
                'tabTitle' => $post->title,
                'post' => $post
            ];
            return view('frontend/pages/single_post', $data);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function contactUs()
    {
        $data = [
            'tabTitle' => 'Contact Us',
            'validation' => null,
        ];

        return view('frontend/pages/contact_us', $data);
    }

    public function contactUsSend()
    {
        $request = \Config\Services::request();

        $isValid = $this->validate([
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Enter your full name',
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Please check the email field. It does not appears to be valid.',
                ],
            ],
            'subject' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Subject is required',
                ]
            ],
            'message' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Message is required',
                ]
            ],
        ]);

        if (!$isValid) {
            $data = [
                'tabTitle' => 'Contact Us',
                'validation' => $this->validator,
            ];
            return view('frontend/pages/contact_us', $data);
        } else {
            $mail_body = 'Message from: <b>' .  $request->getVar('name') . '</b></br>';
            $mail_body .= '---------------------------------</br>';
            $mail_body .= $request->getVar('message') . '</br>';
            $mailConfig = array(
                'mail_from_email' => $request->getVar('email'),
                'mail_from_name' => $request->getVar('name'),
                'mail_recipient_email' => get_settings()->blog_email,
                'mail_recipient_name' => get_settings()->blog_title,
                'mail_subject' => $request->getVar('subject'),
                'mail_body' => $mail_body,
            );
            if (sendEmail($mailConfig)) {
                return redirect()->route('contact-us')->with('success', 'Your message has been sent!');
            } else {
                return redirect()->route('contact-us')->with('fail', 'Something went wrong, Try again later.');
            }
        }
    }
}
