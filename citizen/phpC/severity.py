import pandas as pd, nltk, re, string, pickle


from nltk.corpus import stopwords
from nltk.tokenize import word_tokenize
from nltk.stem import WordNetLemmatizer

nltk.download('punkt')
nltk.download('stopwords')
nltk.download('wordnet')


# Preprocessing
def preprocess(text):

  # Tokenization
  tokens = word_tokenize(text)

  # Convert tokens to lowercase
  tokens = [token.lower() for token in tokens]

  # Remove stopwords, punctuation, and special characters
  stop_words = set(stopwords.words('english'))
  tokens = [
    token for token in tokens
    if token not in stop_words and token not in string.punctuation
  ]
  tokens = [
    re.sub(r"[^\w\s]", "", token)  # Remove special characters
    for token in tokens
  ]

  # Lemmatization
  lemmatizer = WordNetLemmatizer()
  tokens = [lemmatizer.lemmatize(token) for token in tokens]

  # Join tokens back into a single string
  preprocessed_text = ' '.join(tokens)

  return preprocessed_text



# Load the saved model from file
with open("../../model1.pkl", "rb") as file:
    model1 = pickle.load(file)

# Load the CountVectorizer used during training
with open("../../vectorizer1.pkl", "rb") as file:
    vectorizer1 = pickle.load(file)

# Load the saved model from file
with open("../../model2.pkl", "rb") as file:
    model2 = pickle.load(file)

# Load the CountVectorizer used during training
with open("../../vectorizer2.pkl", "rb") as file:
    vectorizer2 = pickle.load(file)



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

# Preprocess the data
description = preprocess(description)

# Preprocess the new text using the same vectorizer
descr_vectorized = vectorizer1.transform([description])

# Make predictions using the loaded model
predicted_severity = model1.predict(descr_vectorized)[0]

print("Severity:", predicted_severity)

# Preprocess the new text using the same vectorizer
descr_vectorized = vectorizer2.transform([description])

# Make predictions using the loaded model
predicted_category = model2.predict(descr_vectorized)[0]

print("Category:", predicted_category)

# Update the incident table with the predicted severity value
query = "SELECT id FROM incident ORDER BY id DESC LIMIT 1"
data = pd.read_sql(query, mydb)
id = data['id'].iloc[0]
update_query = "UPDATE incident SET severity = '{}', category = '{}' WHERE id = {}".format(predicted_severity, predicted_category, id)
cursor = mydb.cursor()
cursor.execute(update_query)
mydb.commit()
