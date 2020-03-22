#!/bin/bash

docker inspect --format='{{json .State.Health}}' nginx