CREATE SCHEMA wordselector;

-- Table word
CREATE TABLE wordselector.word (
    id         serial                NOT NULL,
    word       character varying(45) NOT NULL,
    lang       character(2)          NOT NULL,
    len        integer,
    letters_nb integer,
    complexity numeric(8,5),
    CONSTRAINT word_pkey   PRIMARY KEY (id),
    CONSTRAINT en_word_key UNIQUE (lang, word)
);

-- Table letter_details
CREATE TABLE wordselector.letter_details (
    word_id    INTEGER      NOT NULL,
    letter     CHARACTER(1) NOT NULL,
    occurences INTEGER,
    CONSTRAINT letter_details_pkey         PRIMARY KEY (word_id, letter),
    CONSTRAINT letter_details_word_id_fkey FOREIGN KEY (word_id) REFERENCES wordselector.word (id)
);
