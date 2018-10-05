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

  <style type="text/css">
    .carousel-item .post {
		float:left;
    }
	.post-date {
		text-align: left;
		color: #b5b5b5;
		font-size: 12px;
	}
	.post-desc {
		text-align:left;
	}
	.carousel-control-prev.outside {
		left:-100px;	
	}
	.carousel-control-next.outside {
		right:-100px;	
	}
	.carousel-control-prev-icon.black {
		background-image:url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%222222' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'/%3E%3C/svg%3E");
	}
	.carousel-control-next-icon.black {
		background-image:url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%222222' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E");
	}
  </style>
@section('content')
    <section class="news">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-5">
                    <h2 class="text-center">Новости</h2>
                </div>
            </div>
			<div class="row">
				<div id="carouselNewsIndicators" class="carousel slide carousel-multi-item" data-ride="carousel">			
					<div class="carousel-inner" role="listbox">
						<div class="carousel-item active">
							<!-- начало блока новостей -->
							<div class="col-md-4 post">
								<!-- начало новости -->
								<p class="post-date">11.09.2018</p>
								<p class="post-desc">В конце 2017 г в конструкцию котлов FORTUNA внесены изменения, позволяющие повысить качество оборудования и его эксплуатационные параметры. <a href="/up/ferroli-letter-fortuna.pdf">Подробнее.</a></p>
								<!-- конец новости -->
							</div>
							<div class="col-md-4 post clearfix d-none d-md-block">					
								<p class="post-date">02.09.2018</p>
								<p class="post-desc">Компания ТЕПЛОЦЕЛЬ, г. Ростов-на-Дону стала генеральным дистрибьютором по водонагревателям и котельному оборудованию Ferroli.<img src="/images/teplocel.jpg"></p>
							</div>
							<div class="col-md-4 post clearfix d-none d-md-block">
								<p class="post-date">15.08.2018</p>
								<p class="post-desc">Компания Авангард Система, г. Москва стала официальным дистрибьютором компании Ferroli.<br /> <br /><img src="/images/avangard-cert.jpg"></p>
							</div>
							<!-- конец блока новостей -->
						</div>
						<div class="carousel-item">
							<div class="col-md-4 post">
								<p class="post-date">14.08.2018</p>
								<p class="post-desc">24 апреля 2018 года на заводе группы FERROLI в Белоруссии, ИЗАО ФЕРРОЛИБЕЛ, открылось производство газовых настенных котлов DIVABEL. Мощность производственной линии 20000 котлов в год.<br /><img src="http://service.ferroli.ru//storage/equipments/atf05eFyKUgODP5jekbX8HCNzPyPS5xiIJjCIQKL.jpeg"></p>
							</div>
							<div class="col-md-4 post clearfix d-none d-md-block">
								<p class="post-date">02.08.2018</p>
								<p class="post-desc">Приглашаем к сотрудничеству профессионалов. <br /> ООО «Ферроли Рус», официальное
									представительство
									компании FerroliS.p.A в России, приглашает к сотрудничеству сервисные центры для работы по
									обслуживанию оборудования FERROLI. Для отправки запроса на авторизацию необходимо
									зарегистрироваться в разделе <a href="{{route('register')}}">Регистрация</a></p>
							</div>
							<div class="col-md-4 post clearfix d-none d-md-block">
								<p class="post-date">01.07.2018</p>
								<p class="post-desc">С 1 Августа 2018 года импорт продукции под маркой FERROLI на территорию
									Российской Федерации
									осуществляется исключительно через дочерние юридические лица Группы FERROLI: ООО «ФерролиРус» и
									ИЗАО «ФерролиБел», за исключением модели Fortuna, импорт которой до конца 2018 года будет
									осуществляться структурами компании «Лаборатория Отопления».</p>
								<p class="post-desc">
									Основной задачей представительства Ferroli в России является:
								</p>
								<ul>
									<li class="post-desc">&bull;&nbsp;Обеспечение рынка и Партнеров продукцией, выпускаемой заводами Группы
										Ферроли и запасными
										частями к нему
									</li>
									<li class="post-desc">&bull;&nbsp;Организация сервисной политики и постпродажного/гарантийного
										обслуживания, создание сети
										авторизованных гарантийных сервисных центров
									</li>
									<li class="post-desc">&bull;&nbsp;Маркетинговая поддержка и поддержка продаж</li>
									<li class="post-desc">&bull;&nbsp;Информирование рынка о продукции под маркой Ferroli</li>
									<a href="http://service.ferroli.ru/up/ferroli-letter-1.pdf"><b>ПОДРОБНЕЕ</b></a>
								</ul>
							</div>
						</div>
					</div>
					<a class="carousel-control-prev outside" href="#carouselNewsIndicators" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon black" aria-hidden="true"></span>
						<span class="sr-only">Назад</span>
					</a>						
					<a class="carousel-control-next outside" href="#carouselNewsIndicators" role="button" data-slide="next">
						<span class="carousel-control-next-icon black" aria-hidden="true"></span>
						<span class="sr-only">Вперед</span>
					</a>					
				</div>		
			</div>
			
			
			
        </div>
    </section>
@endsection
