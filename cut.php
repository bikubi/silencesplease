#!/usr/bin/php
<?php
/*
Uses the sidecar files generated by detectsilences.sh to isolate the silences.
Adapted from https://github.com/fjallstrom/p2tystnad/blob/6d4b333e4d2f00a5532dc034a12197b98c61d4a9/recorder.php
Added optional padding and marks the script with comments to be grepped.
Adds duration to the filename for sorting.
*/
define('FFMPEG', 'ffmpeg');
list (, $srcdir, $padding_pre, $padding_post, $thres_long, $thres_short) = $argv;
$outdir = $srcdir; 
function secsToFFMPEG($sec){
	$secsplit = explode(".", $sec);
	$base = date("H:i:s", mktime(0, 0, $secsplit[0], 0, 0, 0));
	return count($secsplit) < 2 ? $base : $base.'.'.$secsplit[1];
}
foreach (glob("$srcdir/*.silences") as $filename) {
	$log = file_get_contents($filename);
	preg_match_all('/silence_start: (.*)/', $log, $matches['starts']);
	preg_match_all('/silence_end: (.*?) /', $log, $matches['ends']);
	preg_match_all('/silence_duration: (.*)/', $log, $matches['durations']);
	$cutlist = array(
		'starts' => $matches['starts'][1],
		'ends' => $matches['ends'][1],
		'durations' => $matches['durations'][1]
	);

	# make a lot of tiny cuts
	for ($i=0; $i<count($cutlist['durations']); $i++) {
		if (floatval($cutlist['starts'][$i]) <= 0) {
			printf("# skipping %s %d\n", $filename, $i);
			continue;
		}
		$srcfn = substr($filename, 0, -9); // cut off suffix '.silences'
		$outfn = $srcfn.sprintf('.%04d.%08d.wav', $i, $cutlist['durations'][$i] * 1000);
		$comment = ' ';
		if (file_exists($outfn)) $comment .= '#exists ';
		if (floatval($cutlist['durations'][$i]) > $thres_long) $comment .= '#long ';
		if (floatval($cutlist['durations'][$i]) < $thres_short) $comment .= '#short ';
		$ss = max(0, $cutlist['starts'][$i] - $padding_pre);
		$to = $cutlist['ends'][$i] + $padding_post;
		printf(
			'%s -i "%s" -ss %s -to %s -y "%s" < /dev/null %s'."\n", // read from null due to https://stackoverflow.com/a/46547313/629238
			FFMPEG, $srcfn, secsToFFMPEG($ss), secsToFFMPEG($to), $outfn, $comment
		);
	}
}
