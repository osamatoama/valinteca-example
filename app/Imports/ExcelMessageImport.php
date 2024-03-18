<?php

namespace App\Imports;

use App\Jobs\SendWhatsSingleMessageExcelJob;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;

class ExcelMessageImport implements ToCollection, WithValidation
{

    private $account;

    private $message;

    private $user_id;

    private $rowNumber;

    private $options;

    private $channel;

    public function __construct($account, $message, $user_id, $rowNumber, $options, $channel)
    {
        $this->account = $account;
        $this->message = $message;
        $this->user_id = $user_id;
        $this->rowNumber = $rowNumber;
        $this->options = $options;
        $this->channel = $channel;
    }

    public function collection(Collection $collection)
    {
        if ($this->options['mood'] == 'slow') {
            $seconds_first = config('whatsapp.first_slow');
            $seconds_end = config('whatsapp.end_slow');
            $has_batch = true;
        } else if ($this->options['mood'] == 'medium') {
            $seconds_first = config('whatsapp.first_medium');
            $seconds_end = config('whatsapp.end_medium');
            $has_batch = true;
        } else if ($this->options['mood'] == 'custom') {
            $seconds_first = $this->options['seconds_first'] ?? 0;
            $seconds_end = $this->options['seconds_end'] ?? 0;
            $has_batch = true;
        } else {
            $seconds_first = 0;
            $seconds_end = 0;
            $has_batch = false;
        }

        $repeat = $this->options['repeat'] ?? 0;
        $repeat_hours = $this->options['repeat_hours'] ?? 0;
        $repeat_times = $this->options['repeat_times'] ?? 0;
        if ($this->options['mood'] == 'custom') {
            $first_batch = $this->options['first_batch'] ?? 0;
            $end_batch = $this->options['end_batch'] ?? 0;
            $first_sleep_minutes = $this->options['first_sleep_minutes'] ?? 0;
            $end_sleep_minutes = $this->options['end_sleep_minutes'] ?? 0;
            $counter = rand($first_batch, $end_batch);
        } else {
            $first_batch = config('whatsapp.first_batch');
            $end_batch = config('whatsapp.end_batch');
            $first_sleep_minutes = config('whatsapp.first_sleep_minutes');
            $end_sleep_minutes = config('whatsapp.end_sleep_minutes');
            $counter = rand($first_batch, $end_batch);
        }

        $add_seconds = 0;
        $stop_seconds = 0;
        use_here($this->account);
        clearQueue($this->account);

        foreach ($collection as $key => $excelRow) {
            $add_seconds += rand($seconds_first, $seconds_end);
            $time = now()->addSeconds($add_seconds);
            $checktime = $time->toTimeString();
            $stop = settings('time_off', $this->user_id) == 1 && $checktime >= settings('from_hour',
                    $this->user_id) && $checktime <= settings('to_hour', $this->user_id);
            if ($has_batch) {
                if ($key > $counter) {
                    $counter += rand($first_batch, $end_batch);
                    $add_seconds += rand($first_sleep_minutes, $end_sleep_minutes) * 60;
                    if ($stop) {
                        $stop_seconds += rand($first_sleep_minutes, $end_sleep_minutes) * 60;
                    }
                }
            }

            if ($stop) {
                $stop_seconds += rand($seconds_first, $seconds_end);
                $diffInSeconds = Carbon::parse(now()->toTimeString())->diffInSeconds(Carbon::parse(settings('to_hour',
                    $this->user_id)));

                $time = now()->addSeconds($diffInSeconds + $stop_seconds);
            } else {
                $time = now()->addSeconds($add_seconds);
            }

            $message = messageExcel($this->message, $excelRow);

            if ($repeat) {
                for ($i = 0; $i < $repeat_times; $i++) {
                    SendWhatsSingleMessageExcelJob::dispatch($this->account,
                        $excelRow[(int)alphabet_to_number($this->rowNumber)], $message,
                        $this->options)->onQueue("scheduled-" . $this->user_id)->delay($time->addSeconds($repeat_hours * 3600));

                    DB::table('jobs')->where('queue', 'scheduled-' . $this->user_id)->update([
                        'user_id' => $this->user_id,
                        'queue'   => 'scheduled',
                    ]);
                }
            } else if ($this->options['type_scheduled']) {
                SendWhatsSingleMessageExcelJob::dispatch($this->account,
                    $excelRow[(int)alphabet_to_number($this->rowNumber)], $message,
                    $this->options)->onQueue("scheduled-" . $this->user_id)->delay($this->options['date']->addSeconds($add_seconds));
            } else {
                SendWhatsSingleMessageExcelJob::dispatch($this->account,
                    $excelRow[(int)alphabet_to_number($this->rowNumber)], $message,
                    $this->options)->onQueue($this->channel)->delay($time);
            }

        }

        if ($this->options['type_scheduled']) {
            DB::table('jobs')->where('queue', 'scheduled-' . $this->user_id)->update([
                'user_id' => $this->user_id,
                'queue'   => 'scheduled',
            ]);
        }

        //        \File::cleanDirectory(storage_path('framework/laravel-excel'));
    }

    public function rules(): array
    {
        return [
            //            '*.number' => 'required|unique:numbers,number',
            //            '*.number' => 'required',
            //            '*.group' =>'required',
        ];
    }
}
