#!/bin/bash
# ARGUMENTS
# 1 output filename
# 2 samplerate
# 3 number of channels
sox -r $2 -c $3 -n $1 synth 0.1 tri 440 fade 0.01 -0 0.01
