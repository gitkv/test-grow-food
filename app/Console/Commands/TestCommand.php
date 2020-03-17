<?php namespace App\Console\Commands;

use App\TestWork\Collections\DataCollectionInterface;
use App\TestWork\Collections\InputDataCollection;
use App\TestWork\Collections\OutputDataCollection;
use App\TestWork\Entities\InputData;
use App\TestWork\Services\DataConverterService;
use Carbon\Carbon;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class TestCommand
 * @package App\Console\Commands
 */
class TestCommand extends Command
{
    /**
     * @var InputDataCollection
     */
    protected $inputDataCollection;

    /**
     * @var OutputDataCollection
     */
    protected $outputDataCollection;

    /**
     * @var DataConverterService
     */
    protected $dataConverterService;

    public function configure()
    {
        $this->setName('test')
            ->setDescription('Запуск выполнения тестового задания')
            ->setHelp('Help for this command');
    }

    protected function setInputData()
    {
        $this->inputDataCollection = new InputDataCollection([
            (new InputData())
                ->setPositionId(1)
                ->setOrderDateFrom(Carbon::parse('2019-02-01'))
                ->setDeliveryDateFrom(Carbon::parse('2019-03-01'))
                ->setPrice(100),

            (new InputData())
                ->setPositionId(1)
                ->setOrderDateFrom(Carbon::parse('2019-02-10'))
                ->setDeliveryDateFrom(Carbon::parse('2019-03-10'))
                ->setPrice(200),

            (new InputData())
                ->setPositionId(1)
                ->setOrderDateFrom(Carbon::parse('2019-02-20'))
                ->setDeliveryDateFrom(Carbon::parse('2019-02-25'))
                ->setPrice(130),
        ]);
    }

    /**
     * @param string $dataName
     * @param DataCollectionInterface $collection
     * @return array
     */
    protected function getInputData(string $dataName, DataCollectionInterface $collection)
    {
        $rows = [$dataName];
        foreach ($collection as $inputDataItem) {
            $rows[] = implode(' | ', $inputDataItem->toArray());
        }
        $rows[] = '';

        return $rows;
    }

    /**
     * @param string $dataName
     * @param DataCollectionInterface $collection
     * @return array
     */
    protected function getInputSearchData(string $dataName, DataCollectionInterface $collection)
    {
        $searchData = [
            ['2019-02-05', '2019-03-15'],
            ['2019-02-15', '2019-03-15'],
            ['2019-02-25', '2019-03-15'],
            ['2019-02-25', '2019-03-05'],
            ['2019-02-25', '2019-02-28'],
        ];

        $rows = [$dataName];
        foreach ($searchData as $searchDatum) {
            $priceResult = $collection->findPrice(1, Carbon::parse($searchDatum[0]), Carbon::parse($searchDatum[1]));
            array_push($searchDatum, $priceResult->first()->getPrice());
            $rows[] = implode(' | ', $searchDatum);
        }
        $rows[] = '';

        return $rows;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setInputData();
        $this->dataConverterService = new DataConverterService($this->inputDataCollection);
        $this->outputDataCollection = $this->dataConverterService->convert();

        $output->writeln($this->getInputData('Входящие данные', $this->inputDataCollection));

        $output->writeln($this->getInputData('Исходящие данные', $this->outputDataCollection));

        $output->writeln($this->getInputSearchData('Поиск по всходящим данным', $this->inputDataCollection));

        $output->writeln($this->getInputSearchData('Поиск по исходящим данным', $this->outputDataCollection));

        return 0;
    }
}
