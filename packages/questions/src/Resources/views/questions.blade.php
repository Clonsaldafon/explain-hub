@extends("layouts.app")

@section("content")
  <section class="questions section container">
    <header class="section__header">
      <div class="questions__search">
        <input
          class="questions__search-input input"
          id="question-search-input"
          name="question"
          type="search"
          placeholder="Поиск..."
        >
        <button
          class="questions__search-button button"
          type="button"
        >
          Найти
        </button>
      </div>
      <a
        class="button button--outlined"
        href="/logout"
      >
        Выйти
      </a>
    </header>
    <div class="section__body">
      <button
        class="questions__add-button button"
        type="button"
      >
        <span class="questions__add-button-text">Задать вопрос</span>
        <svg
          class="questions__add-button-icon"
          width="24" height="24" viewBox="0 0 24 24"
        >
          <path
            fill="currentColor"
            d="M11 13H6q-.425 0-.712-.288T5 12t.288-.712T6 11h5V6q0-.425.288-.712T12 5t.713.288T13 6v5h5q.425 0 .713.288T19 12t-.288.713T18 13h-5v5q0 .425-.288.713T12 19t-.712-.288T11 18z"
          />
        </svg>
      </button>
      <ul class="questions__list">
        <li class="questions__item">
          <x-questions::question
            title="Как найти дифференциал?"
            content="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse eos explicabo quasi a libero nesciunt reprehenderit incidunt consequuntur, dolor maiores architecto provident vero obcaecati impedit, natus officia, excepturi qui quisquam."
            status="published"
            :tags="['вышмат', '2_курс', 'диффуры']"
            :views="357"
            :likes="24"
            id="question-1"
          />
        </li>
        <li class="questions__item">
          <x-questions::question
            title="Как найти дифференциал?"
            content="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse eos explicabo quasi a libero nesciunt reprehenderit incidunt consequuntur, dolor maiores architecto provident vero obcaecati impedit, natus officia, excepturi qui quisquam."
            status="published"
            :tags="['вышмат', '2_курс', 'диффуры']"
            :views="357"
            :likes="24"
            id="question-2"
          />
        </li>
        <li class="questions__item">
          <x-questions::question
            title="Как найти дифференциал?"
            content="Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse eos explicabo quasi a libero nesciunt reprehenderit incidunt consequuntur, dolor maiores architecto provident vero obcaecati impedit, natus officia, excepturi qui quisquam."
            status="published"
            :tags="['вышмат', '2_курс', 'диффуры']"
            :views="357"
            :likes="24"
            id="question-3"
          />
        </li>
      </ul>
    </div>
  </section>
  <div class="modal-overlay" id="modal-overlay"></div>
  <div class="modal" id="modal-form">
    <div class="modal__inner">
      <header class="modal__header">
        <h2 class="modal__title h2">Создание вопроса</h2>
        <button class="modal__close-button">&times;</button>
      </header>
      <div class="modal__body">
        <form id="question-form" method="POST" action="/questions">
          <div class="form-group">
            <label for="title">Вопрос</label>
            <input
              class="input"
              id="title"
              name="title"
              type="text"
              required
            >
          </div>
          <div class="form-group">
            <label for="content">Содержание</label>
            <textarea
              class="textarea"
              id="content"
              name="content"
              rows="5"
              required
            >
            </textarea>
          </div>
          <div class="form-group">
            <label for="tags">Теги (через запятую)</label>
            <input
              class="input"
              id="tags"
              name="tags"
              type="text"
              placeholder="#математика, #программирование"
            >
          </div>
          <button class="button" type="submit">Опубликовать</button>
        </form>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const openModalBtn = document.querySelector('.questions__add-button');
      const modalOverlay = document.getElementById('modal-overlay');
      const modal = document.getElementById('modal-form');
      const closeModalBtn = document.querySelector('.modal__close-button');

      function openModal() {
        modalOverlay.style.display = 'block';
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
      }

      function closeModal() {
        modalOverlay.style.display = 'none';
        modal.style.display = 'none';
        document.body.style.overflow = '';
      }

      if (openModalBtn) {
        openModalBtn.addEventListener('click', openModal);
      }

      if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
      }

      modalOverlay.addEventListener('click', closeModal);

      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.style.display === 'block') {
          closeModal();
        }
      });

      const form = document.getElementById('question-form');
      if (form) {
        form.addEventListener('submit', function(e) {
          e.preventDefault();
          const formData = new FormData(form);

          fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              closeModal();
              location.reload();
            } else {
              alert(data.message);
            }
          })
          .catch(error => console.error('Ошибка:', error));
        });
      }
    });
  </script>
@endsection