@extends('layouts.app')

@section('header')
    <header>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{asset('images/banner/ferroli_home.jpg')}}" alt="">
                </div>
                <div class="carousel-item">
                    <img src="{{asset('images/banner/ferroli_home_1.jpg')}}" alt="">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Назад</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Вперед</span>
            </a>
        </div>
    </header>
@endsection

@section('content')
    <section class="news">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-5">
                    <h2 class="text-center">Новости</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <h3>02.09.2018</h3>
                    <p class="text-justify">Компания ТЕПЛОЦЕЛЬ, г. Ростов-на-Дону стала генеральным дистрибьютором по водонагревателям и котельному оборудованию Ferroli.
			<img src="/images/teplocel.jpg"></p>
                </div>
                <div class="col-sm-4">
		<h3>15.08.2018</h3>
                    <p class="text-justify">Компания Авангард Система, г. Москва стала официальным дистрибьютором компании Ferroli.<br /> <br />
                        <img src="/images/avangard-cert.jpg"></p>
                </div>

		<div class="col-sm-4">
                    <h3>02.08.2018</h3>
                    <p class="text-justify">Приглашаем к сотрудничеству профессионалов. <br /> ООО «Ферроли Рус», официальное
                        представительство
                        компании FerroliS.p.A в России, приглашает к сотрудничеству сервисные центры для работы по
                        обслуживанию оборудования FERROLI. Для отправки запроса на авторизацию необходимо
                        зарегистрироваться в разделе <a href="{{route('register')}}">Регистрация</a></p>
                </div>
            </div>


<div class="row">
                <div class="col-sm-6">
                    <h3>01.07.2018</h3>
                    <p class="text-justify">С 1 Августа 2018 года импорт продукции под маркой FERROLI на территорию
                        Российской Федерации
                        осуществляется исключительно через дочерние юридические лица Группы FERROLI: ООО «ФерролиРус» и
                        ИЗАО «ФерролиБел», за исключением модели Fortuna, импорт которой до конца 2018 года будет
                        осуществляться структурами компании «Лаборатория Отопления».</p>
                    <p>
                        Основной задачей представительства Ferroli в России является:
                    </p>
                    <ul>
                        <li class="p-1 text-justify">&bull;&nbsp;Обеспечение рынка и Партнеров продукцией, выпускаемой заводами Группы
                            Ферроли и запасными
                            частями к нему
                        </li>
                        <li class="p-1 text-justify">&bull;&nbsp;Организация сервисной политики и постпродажного/гарантийного
                            обслуживания, создание сети
                            авторизованных гарантийных сервисных центров
                        </li>
                        <li class="p-1 text-justify">&bull;&nbsp;Маркетинговая поддержка и поддержка продаж</li>
                        <li class="p-1 text-justify">&bull;&nbsp;Информирование рынка о продукции под маркой Ferroli</li>
			<a href="http://service.ferroli.ru/up/ferroli-letter-1.pdf"><b>ПОДРОБНЕЕ</b></a>
                    </ul>

                </div>
            </div>

        </div>
    </section>
@endsection
