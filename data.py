import pandas as pd
from sklearn.feature_selection import SelectKBest, chi2

# Read the CSV file
df = pd.read_csv('dispatch.csv')

# Get the column numbers (indices) you want to keep
column_numbers_to_keep = [1, 2, 3, 6, 7, 8, 10, 11, 12, 13, 15, 19, 20]

# Keep the specified columns
df = df.iloc[:, column_numbers_to_keep]

# Print the updated dataset
print(df)

# Count the number of rows
num_rows = len(df)
print("Number of rows before removing blank data:", num_rows)

# Drop rows with any blank data
df.dropna(inplace=True)

# Count the number of rows after removing blank data
num_rows_after = len(df)
print("Number of rows after removing blank data:", num_rows_after)

# Optional: Save the modified DataFrame to a new CSV file
#df.to_csv('your_file_without_blanks.csv', index=False)

# Display the first few rows of the dataset
print(df.head(5))

# Display summary statistics of the dataset
print(df.describe())

# Display information about the dataset, including column names and data types
print(df.info())

# Separate the features and target variable
X = df.drop('target_variable', axis=1)
y = df['target_variable']

# Select the k best features using chi-square test
k = 5  # Number of features to select
selector = SelectKBest(score_func=chi2, k=k)
X_new = selector.fit_transform(X, y)

# Get the selected feature indices
selected_feature_indices = selector.get_support(indices=True)

# Get the selected feature names
selected_feature_names = X.columns[selected_feature_indices]

# Print the selected features
print(selected_feature_names)



