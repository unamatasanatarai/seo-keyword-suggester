<?php

use Unamatasanatarai\SeoKeywordSuggest\SeoKeywordSuggest;
use Unamatasanatarai\SeoKeywordSuggest\Stopwords\PL;

include __DIR__ . '/../vendor/autoload.php';

$data =<<<EOF
Szef dyplomacji udzielił wywiadu niemieckiemu tygodnikowi "Der Spiegiel". Rozmowa przybrała jednak dość niespodziewany obrót - Witold Waszczykowski spytał na wstępie, czy dziennikarz otrzymał do tej rozmowy "polityczne dyrektywy".
Rozmowę z ministrem spraw zagranicznych Polski "Der Spiegel" poprzedza kilkoma słowami wstępu. Tygodnik cytuje dwie uwagi ministra z zamieszczonego poniżej wywiadu: "Polska czuje się ignorowana i niesprawiedliwie traktowana" i Waszczykowski "wyprasza sobie każdą ingerencje, przede wszystkim ze strony Niemiec".

Ponadto hamburski tygodnik przypomina dawne wypowiedzi szefa polskiego MSW, "którymi się wsławił": "Polsce grozi, że zginie w mieszance kultur i ras i stanie się częścią świata rowerzystów i wegetarian". Tygodnik zauważa, że teraz, po roku urzędowania, Witold Waszczykowski wyraża się bardziej dyplomatycznie.

Rozmowa z hamburskim tygodnikiem odbyła się w siedzibie polskiego MSZ w tydzień po ponownym wyborze Donalda Tuska na przewodniczącego Rady Europejskiej. Przeprowadzający wywiad Jan Pohl zauważa, że w gabinecie ministra wisi portret marszałka Piłsuckiego, "który po I wojnie światowej zdobył dla Polski wolność - a później zamachem znów obalił demokrację".

"Czy to ja mógłbym zadać pierwsze pytanie?"

Rozmowa rozpoczyna się prośbą Witolda Waszczykowskiego pod adresem niemieckiego dziennikarza. Minister pyta go, czy wyjątkowo to on mógłby zadać pierwsze pytanie. Gdy ten się zgadza, szef polskiej dyplomacji pyta Pohla, czy został wysłany do przeprowadzenia rozmowy z nim otrzymując "do wykonania polityczne dyrektywy"?

Dziennikarz zaprzecza i pyta, czy ma to rozumieć jako aluzję do listu, jaki niedawno wydawnictwo Ringer Axel Springer adresował do dziennikarzy swojej polskiej spółki z prośbą, "aby informowali o wydarzeniach w duchu proeuropejskim". Pohl został następnie proszony o ocenę takiego postępowania. Minister zasugerował przy tym, że być może wszystkie niemieckie media otrzymują polityczne dyrektywy.

- To, co zrobiło wydawnictwo, jest oczywistym przykładem  ingerencji w sprawy sąsiedniego kraju. Przy tym, także z Niemiec, od półtora roku zarzuca się nam wywieranie wpływu na prasę. Teraz wydaje się, że mamy dowód na to, że jest odwrotnie - stwierdza Waszczykowski. Dziennikarz "Spiegla" odpowiada, że polecenia we wspomnianym liście nie wydali politycy, lecz prywatny koncern medialny. - U Państwa to rząd próbuje wywierać wpływ - odrzekł Jan Pohl, zapewniając polskiego ministra spraw zagranicznych, że pytania, które mu zada, sam przygotował.

"Musimy bronić własnych polskich interesów"

W pierwszym pytaniu niemiecki dziennikarz pyta Witolda Waszczykowskiego o jego niedawną wypowiedź, że Polska musi "drastycznie obniżyć zaufanie do UE" i "prowadzić także negatywną politykę". Szef polskiej dyplomacji stwierdza: - Przez wiele lat przekonywano nas, że UE jest klubem altruistów, że nie ma już rywalizujących ze sobą interesów narodowych. Najpóźniej od szczytu przed dwoma tygodniami wiemy, że tak nie jest. Nauczyliśmy się, że musimy bronić własnych, polskich interesów. Jasne jest, że mamy mniej władzy i mniejszy potencjał gospodarczy niż Niemcy. Ale chcemy, żeby nasze interesy traktowane były poważnie.
EOF;



//set the length of keywords you like
$params['min_word_length'] = 5;  //minimum length of single words
$params['min_word_occur'] = 2;  //minimum occur of single words

$params['min_2words_length'] = 3;  //minimum length of words for 2 word phrases
$params['min_2words_phrase_length'] = 10; //minimum length of 2 word phrases
$params['min_2words_phrase_occur'] = 2; //minimum occur of 2 words phrase

$params['min_3words_length'] = 3;  //minimum length of words for 3 word phrases
$params['min_3words_phrase_length'] = 10; //minimum length of 3 word phrases
$params['min_3words_phrase_occur'] = 2; //minimum occur of 3 words phrase

$keyword = new SeoKeywordSuggest($params);
$keyword->setStopWords(PL::get())->setContent($data);

echo "KEYWORDS\n";
echo "------------\n\n";
print_r($keyword->parseWords());
echo "\n\n2 x KEYWORDS\n";
echo "----------------\n\n";
print_r($keyword->parse2Words());
echo "\n\n3 x KEYWORDS\n";
echo "----------------\n\n";
print_r($keyword->parse3Words());

echo "\n\nALL\n";
echo "-------\n\n";
print_r($keyword->getKeywords());
echo "\n\n";
