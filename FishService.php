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

    private int $totalNumberOfFishDied = 0;

    public function __construct(private readonly LogInterface $logger) {

    }

    public function simulateFishLifeTime(int $numberOfDays, array $fishesAliveByDay): void {
        if ($numberOfDays <= 0) {
            $this->logger->log(sprintf('Number of days (%d) must be greater than 0.', $numberOfDays));

            return;
        }
        $this->logger->log(sprintf('Calculating the number of fish that died after %d days.', $numberOfDays));

        $this->simulate($numberOfDays, $fishesAliveByDay);

        $this->logger->log(
            sprintf(
                'Finished with %d days',
                $numberOfDays,
            )
        );

        $this->logger->log(
            sprintf(
                'Total fish died: %d',
                $this->totalNumberOfFishDied
            )
        );

    }

    public function simulate(int $numberOfDays, array $fishesAliveByDay): int
    {
        $fishesAliveByDay = array_values($fishesAliveByDay);
        for ($day = 0; $day < $numberOfDays; $day++) {
            $numberOfFishDied = $fishesAliveByDay[0];
            for ($i = 0; $i < count($fishesAliveByDay) - 1; $i++) {
                $fishesAliveByDay[$i] = $fishesAliveByDay[$i + 1];
            }
            unset($fishesAliveByDay[count($fishesAliveByDay) - 1]);
            $fishesAliveByDay[self::DayWhenFishesAreBorn - 1] += $numberOfFishDied;
            $fishesAliveByDay[self::DayWhenNewFishesAreBorn - 1] = $numberOfFishDied;
            $this->totalNumberOfFishDied += $numberOfFishDied;
        }

        return $this->totalNumberOfFishDied;
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