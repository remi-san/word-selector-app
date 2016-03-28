-- Insert
create temporary table t (word character varying(45));
copy t (word) from '/home/macosx/web/twitter-hangman/vendor/remi-san/word-selector/data/words.en.csv' csv;
insert into wordselector.word (word, lang) select word, 'en' from t;
drop table t;
