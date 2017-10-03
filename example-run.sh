#!/bin/bash

# detect silences with duration >= 0.1s 
./detectsilences.sh "duration=0.1" example-audio/example*.mp3 | bash

# extract silences with 0.1s padding at start & end, mark silences longer/shorter than 60/3s
./cut.php ./example-audio 0.1 0.1 60 3 | bash

# make a mono beep, 44khz
./mkbeep.sh beep.wav 44100 1

# mix it all
./concat-w-beeps.sh example-mix.wav beep.wav example-audio/example*.wav
