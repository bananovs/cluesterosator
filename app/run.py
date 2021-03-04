#!/usr/bin/env python  
# -*- coding: utf-8 -*-
import sys
import os
# Fast but low quality
# from modules.kmeans import go_cluster

# Slow and takes a lot of resources, but provides high quality
from modules.affinity_propagation import go_cluster

input_file = sys.argv[1]
output_file = sys.argv[2]
# Testing
# from modules.agglomerative_clustering import go_cluster

# my kmeans method
# from modules.tfidfkmeans import go_cluster

settings = {
    "input_path": input_file,
    "output_path": output_file,
}

itogo = go_cluster(settings["input_path"], settings["output_path"])
print(itogo)