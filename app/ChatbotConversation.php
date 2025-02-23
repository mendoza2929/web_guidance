<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatbotConversation extends Model {

	protected $table = 'chatbot';
	protected $fillable = ['question','response','user_id'];

}
