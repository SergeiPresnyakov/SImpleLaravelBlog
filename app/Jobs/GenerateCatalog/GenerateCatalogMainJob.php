<?php

namespace App\Jobs\GenerateCatalog;

class GenerateCatalogMainJob extends AbstractJob
{
    /**
     * @throws Psr\SimpleCache\InvalidArgumentException
     * @throws Throwable
     */
    public function handle()
    {
        $this->debug('start');

        // Сначала кешируем продукты
        GenerateCatalogCacheJob::dispatchNow();

        // Затем создаем цепочку заданий формирования файлов с ценами
        $chainPrices = $this->getChainPrices();

        // Основные подзадачи
        $chainMain = [
            new GenerateCategoriesJob,
            new GenerateDeliveriesJob,
            new GeneratePointsJob
        ];

        // Подзадачи, которые должны выполняться самыми последними
        $chainList = [
            // Архивирование файлов и перенос архива в публичную папку
            new ArchiveUploadsJob,
            // Отправка уведомления стороннему сервису о том что можно скачать новый файл каталога товаров
            new SendPriceRequestJob
        ];

        $chain = array_merge($chainPrices, $chainMain, $chainList);

        GenerateGoodsFileJob::withChain($chain)->dispatch();

        $this->debug('finish');
    }

    /**
     * Формирование цепочек подзадач по генерации файлов с ценами
     * 
     * @return array
     */
    private function getChainPrices()
    {
        $result = [];
        $products = collect([1, 2, 3, 4, 5]);
        $fileNum = 1;

        foreach ($products->chunk(1) as $chunk) {
            $result[] = new GeneratePricesFileChunkJob($chunk, $fileNum);
            $fileNum++;
        }

        return $result;
    }
}
