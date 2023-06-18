import pandas as pd
import nltk
import random
import string
from nltk.corpus import wordnet
from mtranslate import translate

# Synonym Replacement
def synonym_replacement(sentence):
    tokens = nltk.word_tokenize(sentence)
    replaced_tokens = []

    for token in tokens:
        # Get synonyms for each token
        synonyms = wordnet.synsets(token)
        if synonyms:
            # Replace token with a random synonym
            replaced_token = synonyms[0].lemmas()[0].name()
            replaced_tokens.append(replaced_token)
        else:
            replaced_tokens.append(token)

    replaced_sentence = " ".join(replaced_tokens)
    return replaced_sentence


# Back-Translation
def back_translation(sentence):
    # Translate sentence to a random language (French)
    translation = translate(sentence, 'fr')

    # Translate back to the original language
    back_translation = translate(translation, 'en')

    return back_translation


def character_level_augmentation(text):
    characters = list(text)
    for _ in range(1):
        index = random.randint(0, len(characters) - 1)
        characters[index] = random.choice(string.ascii_letters)
    return ''.join(characters)


# Read the CSV file
data = pd.read_csv('citizen/phpC/incident.csv')

# Augment the data to have 1000 rows
augmented_data = pd.DataFrame(columns=data.columns)
desired_rows = 1000

while len(augmented_data) < desired_rows:
    # Randomly select a row from the original data
    row = data.sample(n=1)

    # Apply a random augmentation technique
    augmentation_choice = random.choice(['synonym_replacement', 'back_translation', 'character_level_augmentation'])
    augmented_description = ''

    if augmentation_choice == 'synonym_replacement':
        augmented_description = synonym_replacement(row['Description'].values[0])
    elif augmentation_choice == 'back_translation':
        augmented_description = back_translation(row['Description'].values[0])
    elif augmentation_choice == 'character_level_augmentation':
        augmented_description = character_level_augmentation(row['Description'].values[0])

    # Add the augmented row to the augmented data
    augmented_row = pd.DataFrame({
        'Description': augmented_description,
        'Severity': row['Severity'].values[0],
        'Category': row['Category'].values[0]
    }, index=[len(augmented_data)])
    augmented_data = pd.concat([augmented_data, augmented_row])

# Concatenate the original data with the augmented data
augmented_data = pd.concat([data, augmented_data])

# Save the augmented data to a new CSV file
augmented_data.to_csv('augmented_data.csv', index=False)
