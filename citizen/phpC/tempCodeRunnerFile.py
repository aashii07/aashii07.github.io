import pandas as pd
import nltk
import random
import string
from nltk.corpus import wordnet
from googletrans import Translator

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
    translator = Translator()

    # Translate sentence to a random language
    translation = translator.translate(sentence, dest='fr')

    # Translate back to the original language
    back_translation = translator.translate(translation.text, dest='en')

    return back_translation.text


def character_level_augmentation(text, num_replacements):
    characters = list(text)
    for _ in range(num_replacements):
        index = random.randint(0, len(characters) - 1)
        characters[index] = random.choice(string.ascii_letters)
    return ''.join(characters)


# Read the CSV file
data = pd.read_csv('citizen/phpC/incident.csv')

# Specify the column name to perform augmentation
column_name = 'Description'

# Apply augmentation techniques on the specified column
data[column_name + '_synonym_replacement'] = data[column_name].apply(synonym_replacement)
data[column_name + '_back_translation'] = data[column_name].apply(back_translation)
data[column_name + '_character_level_augmentation'] = data[column_name].apply(lambda x: character_level_augmentation(x, 1))

# Save the augmented data to a new CSV file
data.to_csv('augmented_data.csv', index=False)
