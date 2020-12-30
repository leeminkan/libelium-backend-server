<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\Interfaces\DeviceRepository;
use Carbon\Carbon;

class CheckActiveDevice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'device:check-active';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check active device';

    /**
     * @var DeviceRepository
     */
    private $device;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DeviceRepository $device)
    {
        parent::__construct();
        $this->device = $device;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        try {
            $devices = $this->device->allWithBuilder()->get();
            $checkTime = Carbon::now();

            foreach ($devices as $device) {
                $data = $device->data_collections()->orderBy('created_at', 'desc')->first();
                if ($data) {
                    try {
                        $compareTime = Carbon::parse($data->created_at)->addHours();
                        if ($compareTime->lt($checkTime)) {
                            if ($device->active) {
                                $this->device->update($device, [
                                    "active" => false
                                ]);
                            }
                        } else {
                            if (!$device->active) {
                                $this->device->update($device, [
                                    "active" => true
                                ]);
                            }
                        }
                    } catch (\Exception $e) {
                        \Log::info($e->getMessage());
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
        }
    }
}
