# FishInTheSea - Fish Population Simulation Challenge

## Overview

This is a programming challenge about simulating fish population over time using caching.

## Problem Description

Calculate the number of fish in the sea after a given number of days, considering:
- Fish live for a maximum of 7 days
- Some fish die after 5 days
- New fish are born on specific days

## Solution Approach

### Array-Based Tracking

Use an array of size 7 (or 8) to track the number of fish at each "age" (day of life):

- Index 0: Fish just born (day 1)
- Index 1-6: Fish on day 2-7 of their life

### Caching Strategy

Since fish only live 7 days, you only need to track a 7-element array:
- Each index represents fish at that age (day 1-7)
- After day 7, fish "shift out" and die
- No need to store the whole period - just the current 7-day state

The company solution likely cached this 7-day array, not the entire 60-day history.

### Algorithm

1. Start with initial fish count by age
2. For each day:
   - Fish at age 0 die (or at age 5, depending on rules)
   - New fish are born
   - Shift ages forward
3. Store each day's state in cache
4. Return the count from the last day

## Files

- `FishService.php` - Main simulation logic
- `LogInterface.php` - Logger interface
- `ConsoleLogger.php` - Console output implementation

## Usage

```bash
php FishService.php [number_of_days]
```

Example:
```bash
php FishService.php 60
```

## Notes

- The current implementation uses recursive simulation
- Consider iterative approach for better performance on larger day counts