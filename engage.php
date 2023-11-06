<?php

include 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$yourAPIKey = $_ENV['OpenAI_YouTube_Comment_Engager_API_Key'];
$client = OpenAI::client($yourAPIKey);
$chatBotSystemMessage = 
"You are an AI assistant whose primary responsibility is to read YouTube the comments,
generate replies, and propose the best replies to me. You should be able to detect mean,
hateful, and rude comments, and produce a canned reply that I can use to reply to the commenter.
Your replies should be kind, thoughtful, and approximately the same length as the comment you are replying to.
Never reply with a rude, hateful or mean comment. Always be kind, thoughtful, and helpful.
If you cannot generate a kind, thoughtful,reply, then do not generate a reply.
The YouTube comments that you receive will be the messages from the user role.";

$noResponseMessage = "I was not able to detect a negative or positive sentiment with this comment.";
$systemMessageArray = ['role' => 'system', 'content' => $chatBotSystemMessage];
$messages = [
    ['role' => 'user', 'content' => 'I hate you'],
    ['role' => 'user', 'content' => 'I really enjoyed this episode!'],
    ['role' => 'user', 'content' => 'Wow, what a cool concept. Have you considered showing your face on camera?'],
    ['role' => 'user', 'content' => 'I dont know about this idea for a channel.']
    
];

# create a while loop that controls the chat conversation with the user and the chatbot
# the while loop should run as long as the userMessage is not equal to 'quit'
# inside the while loop, create a $response variable that calls the chat() method on the $client object
# the chat() method takes an array of messages as an argument
# the array of messages should be the $messages array created above
$chatBotResponses = [];
foreach ($messages as $message)
    print_r($message);
    $response = $client->chat()->create([
        'model' => 'gpt-3.5-turbo',
        'messages' => [$systemMessageArray, $message]
        ]);
    
    $response->id;
    $response->object;
    $response->created;
    $response->model;

    foreach ($response->choices as $result) {
        $result->index;
        $result->message->role;
        $result->message->content;
        $result->finishReason;
    }

    $response->usage->promptTokens;
    $response->usage->completionTokens;
    $response->usage->totalTokens;

    $response->toArray();

    $chatBotResponse = $response->choices[0]->message->content;
    array_push($chatBotResponses, $chatBotResponse);
    print_r($chatBotResponses);

// echo $messages[0]['content'];
// echo ' \r\n';
// echo $chatBotResponses[0];
// echo ' \r\n';
// echo $messages[1]['content'];
// echo ' \r\n';
// echo $chatBotResponses[1];
// echo ' \r\n';
// echo $messages[2]['content'];
// echo ' \r\n';
// echo $chatBotResponses[2];
// echo ' \r\n';
// echo $messages[3]['content'];
// echo ' \r\n';
// echo $chatBotResponses[3];
// echo ' \r\n';