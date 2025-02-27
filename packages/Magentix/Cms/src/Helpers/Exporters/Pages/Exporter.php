<?php

namespace Magentix\Cms\Helpers\Exporters\Pages;

use Illuminate\Support\Facades\Event;
use Magentix\Cms\Repository\PageRepository;
use Webkul\DataTransfer\Helpers\Export;
use Webkul\DataTransfer\Helpers\Exporters\AbstractExporter;
use Webkul\DataTransfer\Contracts\JobTrackBatch as JobTrackBatchContract;
use Webkul\DataTransfer\Jobs\Export\File\FlatItemBuffer as FileExportFileBuffer;
use Webkul\DataTransfer\Repositories\JobTrackBatchRepository;

class Exporter extends AbstractExporter
{
    public function __construct(
        JobTrackBatchRepository $exportBatchRepository,
        FileExportFileBuffer $exportFileBuffer,
        protected PageRepository $pageRepository
    ) {
        parent::__construct($exportBatchRepository, $exportFileBuffer);
    }

    public function exportBatch(JobTrackBatchContract $exportBatchContract, $filePath): bool
    {
        Event::dispatch('data_transfer.exports.batch.export.before', $exportBatchContract);

        $data = $exportBatchContract->data;

        $this->createdItemsCount = count($data);
        $this->processedRowsCount = count($data);

        $this->exportFileBuffer->addData($data, $filePath, $this->getExportParameter());

        $this->updateBatchState($exportBatchContract->id, Export::STATE_PROCESSED);

        Event::dispatch('data_transfer.exports.batch.export.after', $exportBatchContract);

        return true;
    }

    protected function getResults()
    {
        return $this->source->all()?->getIterator();
    }
}
