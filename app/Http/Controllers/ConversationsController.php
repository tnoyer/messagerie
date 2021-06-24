<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
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
     */
    public function __construct(ConversationRepository $conversationRepository, AuthManager $auth){
        $this->cr = $conversationRepository;
        $this->auth = $auth;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        //on récupère tous les utilisateurs sauf l'authentifié
        //$users = User::select('name', 'id')->where('id', '!=', Auth::user()->id)->get();
        return view('conversations/index', [
            'users' => $this->cr->getConversations($this->auth->user()->id)
        ]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show (User $user){
        return view('conversations/show', [
            'users' => $this->cr->getConversations($this->auth->user()->id),
            'user' => $user,
            'messages' => $this->cr->getMessagesFor($this->auth->user()->id, $user->id)->get()
        ]);
    }

    public function store (User $user, StoreMessageRequest $request){
        $this->cr->createMessage(
            $request->get('content'),
            $this->auth->user()->id,
            $user->id
        );

        return redirect(route('conversations.show', ['user' => $user]));
    }
}
