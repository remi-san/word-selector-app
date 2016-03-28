-- Delete letter_details for table
delete from wordselector.letter_details;

-- Update word length
update wordselector.word set len = length(word);

-- Identify letters in words
insert into
  wordselector.letter_details (word_id, letter, occurences)
select
  id,
  letter,
  count(letter)
from (
       select
         w.id,
         regexp_split_to_table(w.word,'') as letter
       from
         wordselector.word w
     ) as letters
where
  letter <> ' '
group by id, letter
order by id, letter;

-- Update nb letters in words table
update wordselector.word w
set letters_nb = nb_letters.cl
from (
	select word_id wid, count(letter) as cl
	from wordselector.letter_details ld
	group by word_id
) as nb_letters
where w.id = nb_letters.wid;

-- Update complexity
update wordselector.word
set complexity = ((letters_nb::numeric*letters_nb::numeric*letters_nb::numeric) / (len::numeric * len::numeric))::numeric;
