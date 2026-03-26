<?php

interface LogInterface
{
    function log(string $message): void;
}

class ConsoleLogger implements LogInterface
{
    function log(string $message): void
    {
        echo $message . PHP_EOL;
    }
}

class FishService
{
    private const DayWhenFishesAreBorn = 6;
    private const DayWhenNewFishesAreBorn = 8;

    private int $totalNumberOfFishesDied = 0;

    public function __construct(private readonly LogInterface $logger) {

    }

    public function simulateFishLifeTime(int $numberOfDays, array $fishesAliveByDay): void {
        if ($numberOfDays <= 0) {
            $this->logger->log(sprintf('Number of days (%d) must be greater than 0.', $numberOfDays));

            return;
        }
        $this->logger->log(sprintf('Calculating the number of fished died after %d days.', $numberOfDays));

        $this->simulate($numberOfDays, $fishesAliveByDay);

        $this->logger->log(
            sprintf(
                'Finished with %d days',
                $numberOfDays,
            )
        );

        $this->logger->log(
            sprintf(
                'Total fished died: %d',
                $this->totalNumberOfFishesDied
            )
        );

    }

    public function simulate(int $numberOfDays, array $fishesAliveByDay): void
    {
        $numberOfFishedDied = array_shift($fishesAliveByDay);
        $fishesAliveByDay[self::DayWhenFishesAreBorn - 1] += $numberOfFishedDied;
        $fishesAliveByDay[self::DayWhenNewFishesAreBorn - 1] = $numberOfFishedDied;
        $this->totalNumberOfFishesDied += $numberOfFishedDied;

        if ($numberOfDays <= 0) {
            return;
        }

        $this->simulate(--$numberOfDays, $fishesAliveByDay);
    }
}

$numberOfDays = $argv[1] ?? 100;
print "$numberOfDays days\n";
$fishesAliveByDay = [
    4,
    0,
    0,
    1,
    0,
    1,
    0,
    0,
];

$service = new FishService(new ConsoleLogger());

$service->simulateFishLifeTime($numberOfDays, $fishesAliveByDay);