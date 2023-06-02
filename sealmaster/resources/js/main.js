// import * as bootstrap from 'bootstrap';

import { Modal, Carousel } from 'bootstrap';

window.Carousel = Carousel;

const modalAskPhoneCall = document.getElementById('modalAskPhoneCall');
const askForCallbackModal = new Modal(modalAskPhoneCall, {});
const userPhoneInput = document.getElementById('userPhone');

modalAskPhoneCall.addEventListener('shown.bs.modal', () => {
  userPhoneInput.focus();
});

const scrollBtn = document.getElementById('back-to-top');
const btnVisibility = () => {
  if (window.scrollY > 600) {
    scrollBtn.style.visibility = 'visible';
  } else {
    scrollBtn.style.visibility = 'hidden';
  }
};

document.addEventListener('scroll', btnVisibility);
scrollBtn.addEventListener('click', (event) => {
  event.preventDefault();
  window.scrollTo({
      top: 0,
      behavior: 'smooth'
  });
});

const generateWorkingHoursList = () => {
  const WORK_HOURS = [
    "09:00 - 18:00",
    "09:00 - 18:00",
    "09:00 - 18:00",
    "09:00 - 18:00",
    "09:00 - 18:00",
    "10:00 - 17:00",
    "10:00 - 17:00",
  ];

  const WEEK_DAYS = [
    "ПН",
    "ВТ",
    "СР",
    "ЧТ",
    "ПТ",
    "СБ",
    "ВС",
  ];

  const now = new Date();
  const currentDay = now.getDay() - 1;
  const whList = document.getElementById('schedule-list');

  WORK_HOURS.forEach((el, idx) => {
    let dayOfWeek;
    let template;

    if (idx === currentDay) {
      dayOfWeek = 'Сегодня';
      template = `<li class="text-end"><span class="me-3 today-list-active">${dayOfWeek}</span><span>${el}</span></li>`;
      document.getElementById('whToggle').insertAdjacentHTML('beforeend', `<span class="me-3 today-list-active">${dayOfWeek}</span><span>${el}</span>`);
    } else {
      dayOfWeek = WEEK_DAYS[idx];
      template = `<li class="text-end"><span class="me-3">${dayOfWeek}</span><span>${el}</span></li>`;
    }

    whList.insertAdjacentHTML('beforeend', template);
  });
};

generateWorkingHoursList();

async function getReviews(url) {
  const response = await fetch(url);

  if (response.ok) {
    const json = await response.json();
    // console.log(json);

    const carousel = document.getElementById('testimonialsList');

    for (let testimonial of json['reviews']) {
      let lacateOptions = { year: 'numeric', month: 'long', day: 'numeric' };
      let testimonialCreated = new Date(Date.parse(testimonial['date_created']));

      let template = `
      <div class="carousel-item">
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="card t-card p-sm-4">
            <span class="icon icon-quote"></span>
            <div class="card-body">
              <figure class="text-start" itemprop="review" itemscope itemtype="http://schema.org/Review">
                <blockquote class="blockquote">
                  <p class="card-text" itemprop="reviewBody">${testimonial['text']}</p>
                </blockquote>
                <figcaption class="testimonial-footer">
                  <img src="${testimonial['user']['photo_preview_urls']['64x64']}" class="rounded-circle img-responsive img-fluid me-3">
                  <div class="testimonial-name">
                    <b itemprop="author">${testimonial['user']['first_name']}</b>
                    <time datetime="${testimonial['date_created']}" class="testimonial-date text-muted">${testimonialCreated.toLocaleDateString('ru', lacateOptions)}</time>
                    <meta itemprop="datePublished" content="${testimonial['date_created']}">
                  </div>
                </figcaption>
              </figure>
            </div>
          </div>
        </div>
      </div>
    </div>
      `;

      carousel.insertAdjacentHTML('beforeend', template);
    }
    carousel.querySelector(':first-child').classList.add('active');

  } else {
    console.log('Ошибка HTTP: ' + response.status);
  }
}

window.getReviews = getReviews;
