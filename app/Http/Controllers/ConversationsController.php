<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Notifications\MessageReceived;
use App\Repository\ConversationRepository;
use App\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationsController extends Controller
{
    /**
     * @var ConversationRepository
     */
    private $cr;

    /**
     * @var AuthManager
     */
    private $auth;

    /**
     * ConversationsController constructor.
     * @param ConversationRepository $conversationRepository
     * @param AuthManager $auth
     */
    public function __construct(ConversationRepository $conversationRepository, AuthManager $auth){
        $this->middleware('auth');
        $this->cr = $conversationRepository;
        $this->auth = $auth;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        return view('conversations/index');
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show (User $user){
        $me = $this->auth->user();
        $messages = $this->cr->getMessagesFor($me->id, $user->id)->paginate(10);
        $unread = $this->cr->unreadCount($me->id);
        if(isset($unread[$user->id])){
            $this->cr->readAllFrom($user->id, $me->id);
            unset($unread[$user->id]);
        }
        return view('conversations/show', [
            'users' => $this->cr->getConversations($me->id),
            'user' => $user,
            'messages' => $messages,
            'unread' => $unread
        ]);
    }

    /**
     * @param User $user
     * @param StoreMessageRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store (User $user, StoreMessageRequest $request){
        $message = $this->cr->createMessage(
            $request->get('content'),
            $this->auth->user()->id,
            $user->id
        );
        //$user->notify(new MessageReceived($message));
        return redirect(route('conversations.show', ['user' => $user]));
    }
}
