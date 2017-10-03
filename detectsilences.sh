#!/bin/bash

# Creates a bash script that uses ffmpeg to detect silences in multiple input files.
# Ffmpeg output is written to a sidecar file for later processing.
#
# USAGE: ./detectsilences.sh OPTIONS FILE1 FILE2...
#   OPTIONS are passed to the silecedetect audio filter, see https://ffmpeg.org/ffmpeg-filters.html#silencedetect
#   FILEs can be a glob.
#   e.g.
#     ./detectsilences duration=0.1 example*.mp3 | bash
#     ./detectsilences "" example*.mp3 # no options, output script to stdout for inspection

FFMPEG="ffmpeg"
opts="$1"
shift
if [ -n "$opts" ] ; then
	opts="=$opts"
fi
for f in "$@"; do
	sidecar="$f.silences"
	echo "echo -n \"$sidecar ... \""
        echo "$FFMPEG -nostats -hide_banner -i \"$f\" -af silencedetect$opts -f null - < /dev/null > \"$sidecar\" 2>&1" # read from null due to https://stackoverflow.com/a/46547313/629238
	echo "grep -c silencedetect \"$sidecar\""
done
