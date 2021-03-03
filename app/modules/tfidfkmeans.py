# --coding: utf8--

import string
import collections
import nltk
import pandas as pd
 
from nltk import word_tokenize
from nltk.stem import PorterStemmer
from nltk.corpus import stopwords as nltk_stopwords
from sklearn.cluster import KMeans
from sklearn.feature_extraction.text import TfidfVectorizer
from modules.io import read_file_to_string, write_string_file

def process_text(text, stem=True):

    # remove punctuation
    
    table = str.maketrans('', '', string.punctuation)
    text = text.translate(table)
    
    # tokenize text
    
    tokens = word_tokenize(text)
    
    # remove stop words
    
    stop_words = set(nltk_stopwords.words('russian') )
    tokens = [word for word in tokens if word not in stop_words]
    
    # stem tokens

    if stem:
        stemmer = PorterStemmer()
        tokens = [stemmer.stem(t) for t in tokens]
 
    return tokens

def cluster_texts(texts, clusters=3):

    # Transform texts to Tf-Idf coordinates and cluster texts using K-Means 

    vectorizer = TfidfVectorizer(tokenizer=process_text,
#                                 stop_words=stopwords.words('english'),
#                                 stop_words='english',
#                                 max_df=1.0,
#                                 min_df=0.5,
                                 lowercase=True)
 
    tfidf_model = vectorizer.fit_transform(texts)#.todense()
    km_model = KMeans(n_clusters = clusters) #, n_jobs = 4)
    km_model.fit(tfidf_model)
 
    clustering = collections.defaultdict(list)
    #df_clusters = pd.DataFrame(columns=['No', 'Cluster']
                                
    rows_list = []
    for idx, label in enumerate(km_model.labels_):
        clustering[label].append(idx)
        rows_list.append([idx, label])
 
    df_clusters = pd.DataFrame(rows_list, columns = ['Text', 'Cluster'])  
    
    # print("Top terms per cluster:")
    # order_centroids = km_model.cluster_centers_.argsort()[:, ::-1]
    # terms = vectorizer.get_feature_names()
    # for i in range(clusters):
    #     print("Cluster %d:" % i),
    #     for ind in order_centroids[i, :5]:
    #         print(' %s' % terms[ind]),
    #     print
    
    # return clustering
    return df_clusters, tfidf_model, km_model

# nltk.download('stopwords')
# nltk.download('punkt')

class LemmatizedTfidfVectorizer(TfidfVectorizer):
    """
    Vectorizer that first lemmatizes words.
    """

    def __init__(self, *args, **kwargs):
        super().__init__(*args, **kwargs)
        self.stemmer = snowballstemmer.stemmer('English')

    def build_analyzer(self):
        analyzer = super(LemmatizedTfidfVectorizer, self).build_analyzer()

        def lemmatize(phrase):
            words = analyzer(phrase)
            return [self.stemmer.stemWord(word)
                    for word in words]

        return lemmatize


def go_cluster(input_path, output_path):
    keywords = []
    min_sentence_length = 3    # minimum length of a sentence to be used in clustering
    num_clusters = 150         # number of clusters to find

    data = read_file_to_string(input_path)

    keywords = [line for line in data.splitlines() if line]
    # running clustering algorithm            
            
    df_clusters, tfidf, km = cluster_texts(keywords, num_clusters)

    # for testing on on 'articles' list run:
    # df_clusters, tfidf, km = cluster_texts(articles, 3)


    

    # make a data frame with sentences and corresponding cluster number for each
    clusters = {}
    # df_articles = pd.DataFrame({'Text':keywords})

    # res = df_clusters.merge(df_articles, left_on='Text', right_on=df_articles.index.values).drop(['Text', 'Text_x'], axis = 1).rename(columns={"Text_y": "Text"}).sort_values(by = 'Cluster')

    # pd.set_option('display.max_colwidth', -1)
    # print(res)

    for keyword, cluster_id in zip(keywords, df_clusters.Cluster):
        clusters.setdefault(cluster_id, []).append(keyword)

    clustered_keywords = ""
    for items in clusters.items():
        for single_item in items[1]:
            clustered_keywords += single_item + '\n'
        clustered_keywords += '\n'

    # print(clustered_keywords)
    write_string_file(output_path, clustered_keywords)
