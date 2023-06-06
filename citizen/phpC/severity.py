from flask import Flask

app = Flask(__name__)

# Import required libraries
import pandas as pd
import re
import nltk
from nltk.corpus import stopwords
from nltk.stem import WordNetLemmatizer
from nltk.corpus import wordnet
from sklearn.model_selection import train_test_split
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score
import mysql.connector

nltk.download('stopwords')
nltk.download('wordnet')
nltk.download('averaged_perceptron_tagger')

@app.route('/')
def index():
    # Call the functions to perform data preprocessing, model training, and database operations
    predicted_severity = preprocess_data_and_predict_severity()
    update_database_with_predicted_severity(predicted_severity)

    # Return a response to the client
    return "Predicted Severity: {}".format(predicted_severity)

def preprocess_data_and_predict_severity():
    # Load and preprocess the data
    data = pd.read_csv('citizen/phpC/filename.csv')
    # Drop columns
    data.drop(['incidentID'], axis=1, inplace=True)

    # Missing values
    data.isna().sum()

    # Preprocessing steps
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

    # Preprocess the description column
    data['descr'] = data['description'].apply(preprocess_text)

    x = data['descr']
    y = data['severity']

    # Train test split (75% train - 25% test)
    x_train, x_test, y_train, y_test = train_test_split(x, y, test_size=0.25, random_state=1)

    # Train Bag of Words model
    cv = CountVectorizer()
    x_train_cv = cv.fit_transform(x_train)

    # Random Forest Classifier
    rfc = RandomForestClassifier()
    rfc.fit(x_train_cv, y_train)

    # Transform X_test using CV
    x_test_cv = cv.transform(x_test)

    # Generate predictions
    predictionRFC = rfc.predict(x_test_cv)

    # Accuracy
    accuracyRFC = accuracy_score(y_test, predictionRFC)
    print(f'Accuracy of RFC = {accuracyRFC}')

    # Fetch the latest description from the incident table
    mydb = mysql.connector.connect(
        host="localhost",
        user="root",
        password="!AAshi4477",
        database="fyp"
    )

    query = "SELECT description FROM incident ORDER BY id DESC LIMIT 1"
    data = pd.read_sql(query, mydb)
    description = data['description'].iloc[0]

    # Preprocess the description from the incident table
    lemmatizer = WordNetLemmatizer()
    stop_words = set(stopwords.words('english')) - set(['not'])

    def preprocess_description(description):
        words = re.findall(r'\b\w+\b', description)
        words = [word.lower() for word in words if word.lower() not in stop_words]
        pos_tags = nltk.pos_tag(words)
        lemmatized_words = [lemmatize_with_pos(word, pos) for word, pos in pos_tags]
        return ' '.join(lemmatized_words)

    preprocessed_description = preprocess_description(description)

    # Transform the preprocessed description using the CountVectorizer model
    desc_cv = cv.transform([preprocessed_description])

    # Use the trained Random Forest Classifier model to predict the severity
    predicted_severity = rfc.predict(desc_cv)[0]
    print("Predicted Severity:", predicted_severity)

    return predicted_severity

def update_database_with_predicted_severity(predicted_severity):
    # Connect to the database
    mydb = mysql.connector.connect(
        host="localhost",
        user="root",
        password="!AAshi4477",
        database="fyp"
    )

    # Fetch the latest incident id
    query = "SELECT id FROM incident ORDER BY id DESC LIMIT 1"
    data = pd.read_sql(query, mydb)
    id = data['id'].iloc[0]

    # Update the incident table with the predicted severity value
    update_query = "UPDATE incident SET severity = '{}' WHERE id = {}".format(predicted_severity, id)
    cursor = mydb.cursor()
    cursor.execute(update_query)
    mydb.commit()

if __name__ == '__main__':
    app.run()
