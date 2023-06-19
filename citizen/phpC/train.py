import pandas as pd, nltk, re, string, pickle

from sklearn.model_selection import train_test_split
from sklearn.neighbors import KNeighborsClassifier
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

# Preprocess the data
data['Description'] = data['Description'].apply(preprocess)

# Split dataset into train and test sets
train_data, test_data = train_test_split(data, test_size=0.20, random_state=7777)

# Remove duplicate rows
train_data = train_data.drop_duplicates()














# Separate input features and target variable for training
X_train1 = train_data["Description"]
y_train1 = train_data["Severity"]

# Create a CountVectorizer object
vectorizer1 = CountVectorizer()

# Fit the vectorizer on the training data
X_train1 = vectorizer1.fit_transform(X_train1)

# Save the vectorizer for future use
with open("vectorizer1.pkl", "wb") as file:
    pickle.dump(vectorizer1, file)

# Train the model
model1 = KNeighborsClassifier()
model1.fit(X_train1, y_train1)

# Save the trained model to a file
with open("model1.pkl", "wb") as file:
    pickle.dump(model1, file)




# Load the saved model from file
with open("model1.pkl", "rb") as file:
    model1 = pickle.load(file)

# Load the CountVectorizer used during training
with open("vectorizer1.pkl", "rb") as file:
    vectorizer1 = pickle.load(file)




# Vectorize the test data
X_test1 = vectorizer1.transform(test_data["Description"])

# Make predictions on the test data
predicted_severity1 = model1.predict(X_test1)

# Calculate accuracy
accuracy1 = accuracy_score(test_data["Severity"], predicted_severity1)
print("Accuracy for testing:", accuracy1)




# Make predictions on the train data
predicted_severity1 = model1.predict(X_train1)

# Calculate accuracy
accuracy1 = accuracy_score(train_data["Severity"], predicted_severity1)
print("Accuracy for training:", accuracy1)















# Separate input features and target variable for training
X_train2 = train_data["Description"]
y_train2 = train_data["Category"]

# Create a CountVectorizer object
vectorizer2 = CountVectorizer()

# Fit the vectorizer on the training data
X_train2 = vectorizer2.fit_transform(X_train2)

# Save the vectorizer for future use
with open("vectorizer2.pkl", "wb") as file:
    pickle.dump(vectorizer2, file)

# Train the model
model2 = KNeighborsClassifier()
model2.fit(X_train2, y_train2)

# Save the trained model to a file
with open("model2.pkl", "wb") as file:
    pickle.dump(model2, file)




# Load the saved model from file
with open("model2.pkl", "rb") as file:
    model2 = pickle.load(file)

# Load the CountVectorizer used during training
with open("vectorizer2.pkl", "rb") as file:
    vectorizer2 = pickle.load(file)




# Vectorize the test data
X_test2 = vectorizer2.transform(test_data["Description"])

# Make predictions on the test data
predicted_severity2 = model2.predict(X_test2)

# Calculate accuracy
accuracy2 = accuracy_score(test_data["Category"], predicted_severity2)
print("Accuracy for testing:", accuracy2)




# Make predictions on the train data
predicted_severity2 = model2.predict(X_train2)

# Calculate accuracy
accuracy2 = accuracy_score(train_data["Category"], predicted_severity2)
print("Accuracy for training:", accuracy2)
