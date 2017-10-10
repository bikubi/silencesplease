# silencesplease

Toolbox to extract silences from a bunch of audio files and concat them.

I wanted to adapt [Peder Fjällström](https://twitter.com/fjallstrom)'s [Swedish Stupid Hackathon 2017](https://www.stupidhackathon.se/) [Project](http://www.p2tystnad.se/) to use with the archives I have captured of [Radio Blau](http://radioblau.de/), where I host a show. Unlike Peter's project this is static, the idea is to extract, like, a month's silences and play them in succession, as I did on [this episode of my show](https://www.mixcloud.com/kubshow/kubshow-18-1994-mit-alex-lorenz/) (around 56:00), and, again [recently, nicer and longer](https://www.mixcloud.com/kubshow/kubshow-26-concrete-jungle-adventures-with-jack-murphy/) (around 20:26).

* I added some padding around the silences - it's less conceptual but more interesting to hear, I believe. You might get the context to why there was silence.
* I have experimented with crossfading as well as "ramp-normalizing" the silences, but this turned out besides the point.
* As much as I would have liked to fully automate the process, the example above is manually edited for interestingness.
* Sorting longest-to-shortest is still nice, I think.

## Prerequisites

* sox
* ffmpeg
* PHP CLI
* bash

## Usage

I provided example data. Run `example-run.sh` & adapt.
