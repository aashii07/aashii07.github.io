import pandas as pd
import nltk
import re
import string
import pickle
from sklearn.model_selection import train_test_split
from sklearn.naive_bayes import MultinomialNB
from sklearn.neighbors import KNeighborsClassifier
from sklearn.linear_model import LogisticRegression
from sklearn.svm import SVC
from sklearn.tree import DecisionTreeClassifier
from sklearn.ensemble import RandomForestClassifier, GradientBoostingClassifier, AdaBoostClassifier
from sklearn.neural_network import MLPClassifier
from sklearn.svm import LinearSVC
from sklearn.linear_model import SGDClassifier
from sklearn.linear_model import RidgeClassifier
from nltk.corpus import stopwords
from nltk.tokenize import word_tokenize
from nltk.stem import WordNetLemmatizer
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.metrics import accuracy_score


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


# Load dataset
data = pd.read_csv("augmented_data.csv")

target = "Severity"
#target = "Category"

# Preprocess the data
data['Description'] = data['Description'].apply(preprocess)

# Split dataset into train and test sets
train_data, test_data = train_test_split(data, test_size=0.20, random_state=7777)

# Remove duplicate rows
train_data = train_data.drop_duplicates()

# Separate input features and target variable for training
X_train = train_data["Description"]
y_train = train_data[target]

# Create a CountVectorizer object
vectorizer = CountVectorizer()

# Fit the vectorizer on the training data
X_train = vectorizer.fit_transform(X_train)

# Save the vectorizer for future use
vectorizer_filename = "vectorizer.pkl"
with open(vectorizer_filename, "wb") as file:
    pickle.dump(vectorizer, file)

models = [
    MultinomialNB(),
    #KNeighborsClassifier(),
    LogisticRegression(),
    SVC(),
    DecisionTreeClassifier(),
    RandomForestClassifier(),
    # GradientBoostingClassifier(),
    # MLPClassifier(),
    # AdaBoostClassifier(),
    # LinearSVC(),
    # SGDClassifier(),
    # RidgeClassifier()
]

# Train and evaluate models
for model in models:
    model.fit(X_train, y_train)

    # Save the trained model to a file
    model_filename = f"{type(model).__name__}.pkl"
    with open(model_filename, "wb") as file:
        pickle.dump(model, file)

    # Load the saved model from file
    with open(model_filename, "rb") as file:
        loaded_model = pickle.load(file)

    # Vectorize the test data
    X_test = vectorizer.transform(test_data["Description"])

    # Make predictions on the test data
    predicted_severity_test = loaded_model.predict(X_test)

    # Calculate accuracy for test data
    accuracy_test = accuracy_score(test_data[target], predicted_severity_test)

    # Vectorize the train data
    #X_train = vectorizer.transform(train_data["Description"])

    # Make predictions on the train data
    #predicted_severity_train = loaded_model.predict(X_train)

    # Calculate accuracy for train data
    #accuracy_train = accuracy_score(train_data[target], predicted_severity_train)

    print("Model:", model)
    print("Accuracy for test data:", accuracy_test)
    #print("Accuracy for train data:", accuracy_train)
    print()

