<?php

namespace App\Listeners;

use App\Events\MqttPushlisher;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Salman\Mqtt\MqttClass\Mqtt;

class PushlishMessage implements ShouldQueue
{
    public $mqtt;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Mqtt $mqtt)
    {
        //
        $this->mqtt = $mqtt;
    }

    /**
     * Handle the event.
     *
     * @param  MqttPushlisher  $event
     * @return void
     */
    public function handle(MqttPushlisher $event)
    {
        //

        $output = $this->mqtt->ConnectAndPublish($event->topic, $event->message);

        if ($output === true)
        {
            \Log::info("Pushlish message success. Detail: " . json_encode([
                "topic" => $event->topic,
                "message" => $event->message
            ]));
        } else {
            \Log::alert("Pushlish message fail. Detail: " . json_encode([
                "topic" => $event->topic,
                "message" => $event->message
            ]));
        }
    }
}
