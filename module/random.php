<?php
$first_name = array('Августа','Аврелія','Аврора','Агапія','Агата','Агафія','Аза','Аліна',
    'Аліса','Анна','Валерія','Віолетта','Галина','Дарина','Килина','Трояна','Тамара','Софія','Северина',
    'Ведан','Водотрав','Вітрян','Дарій','Данило','Дорогосил','Володар','Лютобор','Олелько');
$last_name = array('Кравчук','Корнейчук','Коровяк','Стецькив','Бандурко','Бондарь','Бондаренко',
    'Бондарчук','Бородай','Бубенко','Буденный','Бутенко','Бутко','Васильченко','Виленский','Волынец',
    'Захаренко','Задорожный','Захарченко','Захарко','Кавун','Калиниченко','Коваль','Коваленко',
    'Козловский','Колесниченко','Коломиец','Кондратюк','Корниенко','Краско');

$string = '
Андросюк Сергій Юрійович	
* Арсенюк Єгор Ігорович	
* Атаманенко Євгеній Ігорович	
* Бабоїд Валентин Сергійович	
* Баранівський Володимир Вікторович	
* Батрак Анна Олександрівна	
* Безуглий Давид Євгенович	
* Берестенко Радміла Ігорівна	
* Битько Софія Миколаївна	
* Білоус Юлія Юріївна	
* Білоус Ярослав Олександрович	
* Богун Іван Сергійович	
* Бойко Анастасія Сергіївна	
* Бойко Антон Миколайович	
* Боковенко Віта Петрівна	
* Бондар Іван Олександрович	
* Борисова Марія Дмитрівна	
* Борсук Анастасія Маратівна	
* Боханевич Вікторія Олегівна	
* Бражник Богдан Олександрович	
* Бриженко Анна Романівна	
* Бриженко Антон Романович	
* Бузинний Владислав Миколайович	
* Бурдіян Аліна Вікторівна	
* Бурима Артем Олександрович	
* Бурлій Денис Анатолійович	
* Бутенко Дарина Володимирівна	
* Буханевич Людмила Олексіївна	
* Бучинська Яна Анатоліївна	
* Василевський Дмитро Ігорович	
* Василенко Вікторія Вадимівна	
* Васільченко Аліна Олександрівна	
* Величко Сніжана Костянтинівна	
* Вовк Владислав Олександрович	
* Вовченко Богдан Юрійович	
* Вовченко Марина Олександрівна	
* Вовченко Петро Анатолійович	
* Войтенко Дмитро Св`ятославович	
* Волошин Дарія Миколаївна	
* Воронецька Софія Сергіївна	
* Воротинцев Петро Ігорович	
* В`язовікова Анастасія Андріївна	
* Гаврилишин Андрій Вікторович	
* Гайдамака Владислав Олександрович	
* Гайдамака Давид Олегович	
* Галкіна Вікторія Олександрівна	
* Гирич Яна Володимирівна	
* Гіззатуліна Віолетта Денисівна	
* Гіззатуллін Данило Денисович	
* Гладкевич Оксана Тарасівна	
* Гладкевич Уляна Тарасівна	
* Глевацький Владислав Васильович	
* Глевацький Денис Васильович	
* Гнатенко Владислав Васильович	
* Гнатівський Арсен Віталійович	
* Гнатівський Євгеній Віталійович	
* Гниліцький Едуард Олександрович	
* Гойденко Анастасія Сергіївна	
* Голик Антон Віталійович	
* Голоско Марія Олександрівна	
* Голоско Світлана Олександрівна	
* Гончаренко Олександр Олександрович	
* Горбуненко Вікторія Віталіївна	
* Горбуненко Вікторія Володимирівна	
* Гордієнко Данііл Романович	
* Горіна Вероніка Віталіївна	
* Гороховський Богдан Михайлович	
* Гороховський Олександр Сергійович	
* Гороховський Ярослав Сергійович	
* Горошко Єлизавета Миколаївна	
* Горошко Михайло Ігорович	
* Гречінська Аміна Володимирівна	
* Гречінський Іван Володимирович	
* Григоренко Діана Олександрівна	
* Григоренко Ірина Олександрівна	
* Гудемчук Анастасія Віталіївна	
* Гудемчук Іван Віталійович	
* Гуляніцька Катерина Юріївна	
* Гуляніцький Богдан Юрійович	
* Гуменюк Олександр Володимирович	
* Дахно Ірина Вікторівна	
* Даценко Аліна Іванівна	
* Дениско Олександр Олександрович	
* Деркач Владислав В`ячеславович	
* Дишлюк Микола Русланович	
* Дмитренко Ольга Олександрівна	
* Довгопола Богдана Богданівна	
* Дротов Владислав Вячеславович	
* Дротов Дмитро В`ячеславович	
* Ємець Анастасія Павлівна	
* Ємець Владислав Олександрович	
* Єрмолович Марія Владиславівна	
* Желізняк Віолетта Денисівна	
* Житник Анастасія Анатоліївна	
* Журавель Остап Сергійович	
* Жученко Валентин Васильович	
* Завальний Нікіта Олександрович	
* Задніпряний Євгеній Павлович	
* Задорожній Іван Олександрович	
* Задорожній Назарій Олександрович	
* Заікін Микита Андрійович	
* Заікіна Олександра Андріївна	
* Зеленська Аліна Вікторівна	
* Зеленський Ярослав Вікторович	
* Зізенко Богдан Олегович	
* Зізенко Олеся Володимирівна	
* Зінченко Дар`я Станіславівна	
* Зражевська Анна Григорівна	
* Зражевська Яна Григорівна	
* Іванов Ілля Павлович	
* Іванова Софія Павлівна	
* Іванченко Дарія Олегівна	
* Іонов Марк Валерійович	
* Іонова Анастасія Сергіївна	
* Іонова Каріна Валеріївна	
* Іщенко Богдан Вікторович	
* Іщенко Дарія Олегівна	
* Калачнюк Вікторія Вікторівна	
* Калініченко Павло Миколайович	
* Каплична Лідія Сергіївна	
* Кизима Софія Михайлівна	
* Кирпата Анна Андріївна	
* Кияшко Дарина Ігорівна	
* Климанська Софія Олександрівна	
* Клоченко Олександр Олександрович	
* Кобилко Оксана Олександрівна	
* Кобко Владислава Ігорівна	
* Ковалевський Богдан Русланович	
* Коваленко Аліна Миколаївна	
* Коваленко Ірина Миколаївна	
* Коваленко Маргарита Анатоліївна	
* Коваль Інна Олегівна	
* Коваль Ірина Богданівна	
* Ковбаса Катерина Василівна	
* Козленко Аліна Ігорівна	
* Козленко Альона Олександрівна	
* Козленко Богдан Володимирович	
* Кокоша Валерія Олексіївна	
* Колесник Руслан Ярославович	
* Колибаба Анастасія Михайлівна	
* Колибаба Іван Сергійович	
* Колісник Арсен Олексійович	
* Коломієць Богдан Андрійович	
* Коломієць Ельвіра Віталіївна	
* Коломієць Іван Андрійович	
* Коломієць Марія Іванівна	
* Коломієць Олександр Сергійович	
* Конончук Крістіна Антонівна	
* Корнієнко Дмитрій Юрійович	
* Кравченко Дарина Юріївна	
* Крамар Аліна Миколаївна	
* Красавін Валерій Вікторович	
* Красюк Марія Володимирівна	
* Крегул Богдан Юрійович	
* Кривко Гліб Ігорович	
* Кривобок Катерина Сергіївна	
* Крижанівський Станіслав Олексійович	
* Кубко Владислава Валеріївна	
* Кубко Єлизавета Валеріївна	
* Кузько Анна Юріївна	
* Кулаківська Анастасія Олександрівна	
* Кулаківська Катерина Олександрівна	
* Кулаківська Надія Олександрівна	
* Кулаківська Софія Олександрівна	
* Кулаківський Ілля Олександрович	
* Кулаківський Тимофій Олександрович	
* Кулик Олександра Юріївна	
* Кульчіцька Ірина Сергіївна	
* Кустовський Андрій Ігорович	
* Кустовський Богдан Ігорович	
* Кустовський Максим Сергійович	
* Кустовський Максим Сергійович	
* Кутєпова Олена Олександрівна	
* Кутовий Михайло Миколайович	
* Куцовол Антон Юрійович	
* Кучер Владислав Олександорович	-б Кучер Іван Олегович	
* Кучеренко Олексій Іванович	
* Лафенко Вікторія Вікторівна	
* Лелюх Діана Миколаївна	
* Лисак Анастасія Юріївна	
* Литвин Ірина Ігорівна	
* Литвин Олена Олександрівна	
* Литвин Павло Ігорович	
* Литовченко Артем Олексадрович	
* Лихвенко Даніель Олександрівна	
* Лихвенко Наталія Олександрівна	
* Лілієнко Богдан Романович	
* Лінива Катерина Сергіївна	
* Лініченко Марія Сергіївна	
* Ліснічук Надія Олегівна	
* Лісовенко Марина Віталіївна	
* Літянський Артем Володимирович	
* Луб"яний Ігор Олександрович	
* Луханін Андрій Сергійович	
* Лученко Віталій Віталійович	
* Любчич Богдана Борисівна	
* Мазурик Олександра Сергіївна	
* Майстренко Анна Юріївна	
* Майстренко Максим Сергійович	
* Макаренко Ярослав Віталійович	
* Макаров Сергій Олександрович	
* Малий Дмитро Ігорович	
* Мальована Світлана Русланівна	
* Мальований Владислав Русланович	
* Маналатьєв Вячеслав Геннадійович	
* Маналатьєв Дмитро Олександрович	
* Маналатьєва Анастасія Олександрівна	
* Манзюк Владислав Юрійович	
* Мартиненко Артем Вадимович	
* Марчук Аліна Миколаївна	
* Марчук Артем Романович	
* Маршук Олександр Георгійович	
* Маслов Юрій Дмитрович	
* Метельська Карина Олексіївна	
* Микитенко Інеса Андріївна	
* Митківська Ірина Юріївна	
* Михайлівська Ангеліна Віталіївна	
* Михайлюк Ірина Павлівна	
* Мовчанівська Аріана Володимирівна	
* Модлінський Ернест Віталійович	
* Музичук Богдан Ярославович	
* Муха Євгеній Андрійович	
* Навроцький Валерій Олексійович	
* Нагірний Ілля Миколайович	
* Недодар Владислав Русланович	
* Немировська Ірина Олегівна	
* Нестеренко Анастасія Сергіївна	
* Нестеренко Марія Сергіївна	
* Нечай Тетяна Олегівна	
* Нечипоренко Володимир Васильович	
* Нечипоренко Денис Васильович	
* Нечипоренко Євгенія Владиславівна	
* Нечипуренко Ілона Вікторівна	
* Носенко Марія Тарасівна	
* Носенко Тетяна Тарасівна	
* Оверчук Олексій Сергійович	
* Озадовський Владислав Миколайович	
* Озадовський Ігор Віталійович	
* Озадовський Олег Віталійович	
* Охрімчук Ілля Богданович	
* Павленко Андрій Олександрович	
* Палагей Анна Сергіївна	
* Паламарчук Назарій Вікторович	
* Панасюк Андрій Васильович	
* Панасюк Дмитро Віталійович	
* Панасюк Олександр Романович	
* Пекельна Діана Юріївна	
* Переляк Олександр Олексійович	
* Петрич Юрій Анатолійович	
* Петрівський Денис Євгенович	
* Петруневич Віталій Іванович	
* Печеніна Валентини Олександрівна	
* Півень Владислав Віталійович	
* Піщаний Віктор Сергійович	
* Піщаний Олексій Сергійович	
* Погорецька Вікторія Валентинівна	
* Погорецька Наталія Олександрівна	
* Погорецький Віталій Валентинович	
* Поліщук Анатолій Анатолійович	
* Поліщук Богдан Вікторович	
* Поліщук Вікторія Олександрівна	
* Поліщук Максим Олегович	
* Поліщук Руслана Сергіївна	
* Помінов Владислав Володимирович	
* Помінова Дарина Володимирівна	
* Порхун Тетяна Сергіївна	
* Постоєва Олександра Ігорівна	
* Пошелюжний Дмитро Петрович	
* Приймак Микола Миколайович	
* Прокопенко Анжеліка Леонідівна	
* Пузько Ілля Олександрович	
* П`ятецька Марія Олександрівна	
* Рагімов Ельчін Ельдарович	
* Радіонова Валерія Іванівна	
* Радкевич Ігор Тимурович	
* Ратушна Ірина Олександрівна	
* Ратушна Олександра Валеріївна	
* Рибалко Вадим Миколайович	
* Росінська Анастасія Сергіївна	
* Рубіженко Вікторія Олександрівна	
* Рудаков Віктор Олександрович	
* Рудакова Наталія Сергіївна	
* Рудакова Ольга Сергіївна	
* Рябовол Катерина Володимирівна	
* Савіченко Поліна Ігорівна	
* Савченко Вероніка Сергіївна	
* Салганенко Володимир Олексійович	
* Сальник Марко Юрійович	
* Сальник Сергій Дмитрович	
* Сальнік Ельвіра Вікторівна	
* Самченко Аліна Олегівна	
* Семенченко Яна Василівна	
* Сироветник Вікторія Вікторівна	
* Сироткіна Вікторія Олександрівна	
* Сич Дмитро Вікторович	
* Скаба Артем Олександрович	
* Скакунов Назар Сергійович	
* Скотніцька Діана Русланівна	
* Слюсаренко Дмитро Романович	
* Смолін Дмитро Сергійович	
* Старчевич Владислава Віталіївна	
* Степаненко Діана Олегівна	
* Степков Іван Олексійович	
* Степченко Юлія Сергіївна	
* Столярчук Іван Миколайович	
* Сухомлин Богдан Петрович	
* Сущенко Катерина Панасівна	
* Тер Альбіна Андріївна	
* Тертиця Катерина Леонідівна	
* Тертичний Максим Ярославович	
* Тихоненко Денис Дмитрович	
* Тітова Анастасія Ігорівна	
* Ткаченко Анна Русланівна	
* Ткаченко Володимир Анатолійович	
* Ткаченко Дарина Олександрівна	
* Ткаченко Дмитро Вадимович	
* Ткаченко Дмитро Романович	
* Ткаченко Ліля Юріївна	
* Товстенко Назарій Андрійович	
* Топало Дмитро Віталійович	
* Топало Олександр Віталійович	
* Троян Вячеслав Віталійович	
* Трукін Богдан Геннадійович	
* Тупчій Ігор Вадимович	
* Тупчій Інна Вадимівна	
* Турчина Каріна Валеріївна	
* Турчина Христина Валеріївна	
* Федкевич Олександр Васильович	
* Федоренко Дмитро Святославович	
* Федоренко Наталія Святославівна	
* Фещенко Антон Олександрович	
* Фещенко Дарина Ігорівна	
* Філіпась Ілля Андрійович	
* Фурманенко Віталій Сергійович	
* Фурманенко Ольга Сергіївна	
* Хоменко Аліна Олександрівна	
* Хоменко Євгенія Олексіївна	
* Хоменко Іван Іванович	
* Хоменко Наталія Олексіївна	
* Хоменко Олександр Олександрович	
* Христевич Наталія Ігорівна	
* Худченко Інна Дмитрівна	
* Цимбалюк Вікторія Юріївна	
* Чава Ірина Вікторівна	
* Чава Наталія Вікторівна	
* Чала Ірина Олександрівна	
* Чепілко Олександр Іванович	
* Черник Ілля Михайлович	
* Чорна Вікторія Сергіївна	
* Чорна Інна Сергіївна	
* Шевченко Яна Сергіївна	
* Шевченко-Корженецька Марія Дмитрівна	
* Шевченко-Корженецький Олексій Дмитрович	
* Шевчук Вікторія Володимирівна	
* Шевчук Микола Павлович	
* Шеремет Андрій Володимирович	
* Шерепенко Ілля Миколайович	
* Шимченко Віталіна Русланівна	
* Шимченко Єгор Русланович	
* Шкарівський Владислав Вадимович	
* Шкаруба Аліна Віталіївна	
* Шкляренко Ярослав Ігорович	
* Шкорина Віта Олександрівна	
* Шкорина Вячеслав Олександрович	
* Шматок Ольга Миколаївна	
* Шнуренко Тетяна Олександрівна	
* Шпильова Тетяна Віталіївна	
* Шпильовий Артем Олексійович	
* Шрамко Олена Василівна	
* Шульц Анна Вячеславівна	
* Шульц Дмитро Вячеславович	
* Шустік Євгеній Сергійович	
* Щербинка Ярослав Володимирович	
* Якименко Інна Юріївна	
* Якименко Яна Петрівна	
* Яковенко Юлія Василівна	
* Яременко Іван Олександрович	
* Ярославцева Анастасія Володимирівна	
* Ярославцева Анна Володимирівна	
* Ясенова Анна Вадимівна	
* Ясеновий Артем Вадимович	
* Ясеновий Вадим Анатолійович	
* Ясеновий Сергій Анатолійович	
* Яцевська Анжела Олександрівна	
* Яцевська Наталія Сергіївна	
* Яценко Дмитро Анатолійович';
for($i=0;$i<398;$i++){
$string =str_replace($i,'',$string);

}
$string =str_replace('-А','<br>*',$string);
$string =str_replace('-Б','<br>*',$string);
echo $string;
