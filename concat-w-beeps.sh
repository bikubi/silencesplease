#!/bin/bash

# Concats audio files interleaved with a separator clip.
# They are sorted longest-to-shorted, as indicated by the filename
# (4th column; make sure to check that sort command).
#
# USAGE: ./concat-w-beeps.sh OUT.wav BEEP.wav FILE1.wav FILE2.wav ...

outfn="$1"
shift
sepfn="$1"
shift
sox -V3 "$sepfn" \
	$(\
		for f in "$@"; do echo "$f"; done \
		| sort -t. -k 4 -r \
		| while read g; do \
			echo "$g"; echo "$sepfn"; \
		  done \
	)\
	"$outfn"
