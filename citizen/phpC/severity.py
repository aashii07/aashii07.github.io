#importing dataset
import pandas as pd
data = pd.read_csv('citizen/phpC/filename.csv')

#drop columns
data.drop(['incidentID'], axis=1, inplace=True)

#missing values
data.isna().sum()

#preprocessing
import re
import nltk
from nltk.corpus import stopwords
from nltk.stem import WordNetLemmatizer
from nltk.corpus import wordnet

nltk.download('stopwords')
nltk.download('wordnet')
nltk.download('averaged_perceptron_tagger')

lemmatizer = WordNetLemmatizer()
stop_words = set(stopwords.words('english')) - set(['not'])

def lemmatize_with_pos(word, pos_tag):
  pos_map = {'N': wordnet.NOUN, 'V': wordnet.VERB, 'R': wordnet.ADV, 'J': wordnet.ADJ}
  pos = pos_map.get(pos_tag[0], wordnet.NOUN)
  return lemmatizer.lemmatize(word, pos=pos)

def preprocess_text(text):
  words = re.findall(r'\b\w+\b', text)
  words = [word.lower() for word in words if word.lower() not in stop_words]
  pos_tags = nltk.pos_tag(words)
  lemmatized_words = [lemmatize_with_pos(word, pos) for word, pos in pos_tags]
  return ' '.join(lemmatized_words)

#remove all special characters, lowercase all the words, tokenize, remove stopwords, lemmatize
data['descr'] = data['description'].apply(preprocess_text)

x = data['descr']
y = data['severity']

#train test split (75% train - 25% test)
from sklearn.model_selection import train_test_split

x_train, x_test, y_train, y_test = train_test_split(x, y, test_size=0.25, random_state=1)

#train Bag of Words model
from sklearn.feature_extraction.text import CountVectorizer

cv = CountVectorizer()
x_train_cv = cv.fit_transform(x_train)
x_train_cv.shape

#Random Forest Classifier
from sklearn.ensemble import RandomForestClassifier

rfc = RandomForestClassifier()
rfc.fit(x_train_cv, y_train)

#transform X_test using CV
x_test_cv = cv.transform(x_test)

#generate predictions
predictionRFC = rfc.predict(x_test_cv)

#accuracy
from sklearn.metrics import accuracy_score
accuracyRFC = accuracy_score(y_test, predictionRFC)
print(f'Accuracyof RFC = {accuracyRFC}')









# Import required libraries
import mysql.connector

# Connect to the database
mydb = mysql.connector.connect(
  host="localhost",
  user="root",
  password="!AAshi4477",
  database="fyp"
)

# Define the SQL query to fetch the latest description from the incident table
query = "SELECT description FROM incident ORDER BY id DESC LIMIT 1"

# Fetch the data from the database using pandas
data = pd.read_sql(query, mydb)

# Extract the description from the data dataframe
description = data['description'].iloc[0]

# Initialize lemmatizer and stop words
lemmatizer = WordNetLemmatizer()
stop_words = set(stopwords.words('english')) - set(['not'])

def lemmatize_with_pos(word, pos_tag):
  pos_map = {'N': wordnet.NOUN, 'V': wordnet.VERB, 'R': wordnet.ADV, 'J': wordnet.ADJ}
  pos = pos_map.get(pos_tag[0], wordnet.NOUN)
  return lemmatizer.lemmatize(word, pos=pos)

def preprocess_description(description):
  words = re.findall(r'\b\w+\b', description)
  words = [word.lower() for word in words if word.lower() not in stop_words]
  pos_tags = nltk.pos_tag(words)
  lemmatized_words = [lemmatize_with_pos(word, pos) for word, pos in pos_tags]
  return ' '.join(lemmatized_words)

# Extract description from HTML form and preprocess it
preprocessed_description = preprocess_description(description)


# Load the trained CountVectorizer model
cv = CountVectorizer()
x_train_cv = cv.fit_transform(x_train)

# Transform the preprocessed description using the CountVectorizer model
desc_cv = cv.transform([preprocessed_description])

# Use the trained Random Forest Classifier model to predict the severity
predicted_severity = rfc.predict(desc_cv)[0]
print("Predicted Severity:", predicted_severity)

# Update the incident table with the predicted severity value
query = "SELECT id FROM incident ORDER BY id DESC LIMIT 1"
data = pd.read_sql(query, mydb)
id = data['id'].iloc[0]
update_query = "UPDATE incident SET severity = '{}' WHERE id = {}".format(predicted_severity, id)
cursor = mydb.cursor()
cursor.execute(update_query)
mydb.commit()
