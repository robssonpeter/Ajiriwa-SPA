<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ExportJobs extends Command
{
    protected $signature = 'export:jobs';

    protected $description = 'Export jobs from the database to JSON';

    public function handle()
    {
        $outputFile = 'jobs.json';

        $this->info('Exporting jobs...');

        // Chunking query to retrieve jobs in batches
        Job::chunk(1000, function ($jobs) use ($outputFile) {
            $jobDataset = [];

            foreach ($jobs as $job) {
                $jobEntry = [
                    'job_title' => $job->title,
                    'job_location' => $job->location,
                    'application_method' => $job->apply_method,
                    'application_deadline' => Carbon::parse($job->deadline)->toDateString(), // Assuming application_deadline is a date field
                    'job_description' => $job->description,
                    'application_email' => $job->application_email,
                    'application_url' => $job->application_url
                ];

                $jobDataset[] = $jobEntry;
            }

            // Append or create the JSON file
            Storage::append($outputFile, json_encode($jobDataset, JSON_PRETTY_PRINT));
        });

        $this->info('Export completed. File saved as ' . $outputFile);
    }
}
