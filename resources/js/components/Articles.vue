<script setup>
  import { ref } from "vue";
  const articles = ref([]);
  const article = ref({
    id: '',
    title: '',
    body: ''
  });
  const article_id = ref('');
  const pagination = ref({});
  const edit = ref(false);

  const makePagination = (meta, links) => {
    const new_pagination = {
      current_page: meta.current_page,
      last_page: meta.last_page,
      next_page_url: links.next,
      prev_page_url: links.prev
    };
		pagination.value = {...new_pagination};
		console.log(pagination.value);
  }

  const getArticles = (page_url='') => {
    page_url = page_url || 'api/articles';
    fetch(page_url)
      .then(res => res.json())
      .then(resp => {
        console.log(resp);
				articles.value = resp.data;
				makePagination(resp.meta, resp.links);
      })
			.catch(err => console.log(err)
		);
	}
		
	const deleteArticle = (articleId) => {
		if(confirm('Arre you Sure the you want to delete this Article?')){
			fetch(`api/articles/${articleId}`, {
				method: 'delete'
			})
			.then(res => res.json())
			.then(data => {
				alert('Articles removed!');
				getArticles();
			})
			.catch(err => console.log(err));
		}
	}

	const addArticle = () => {
		if(!edit.value){
			// Add
			fetch('api/articles', {
				method: 'post',
				body: JSON.stringify(article.value),
				headers: {
					'Content-type': 'application/json'
				}
					})
					.then(res => res.json())
					.then(data => {
						article.value.title = '';
						article.value.body = '';
						alert('The articles has been Added');
						getArticles();
					})
					.catch(err => console.log(err)
				);
		}else{
			// Update
			fetch(`api/articles/${article_id.value}`, {
				method: 'put',
				body: JSON.stringify(article.value),
				headers: {
					'Content-type': 'application/json'
				}
					})
					.then(res => res.json())
					.then(data => {
						article.value.title = '';
						article.value.body = '';
						alert('The articles has been Updated');
						getArticles();
					})
					.catch(err => console.log(err)
				);
		}
	}

	const editArticle = (new_article) => {
		edit.value = true;
		article.value.id = new_article.id;
		article.value.title = new_article.title;
		article.value.body = new_article.body;
		article_id.value = new_article.id;
	}

  // fetch the data
  getArticles();
</script>

<template>
  <div class="flex flex-col">
    <div class="flex flex-col ml-5 pl-5">
			<p
				class="text-3xl"
			>
				List of Articles
			</p>
		</div>
		<form
			class="m-5 p-5"
			@submit.prevent="addArticle"
		>
			<div class="mb-6">
				<input
					type="text"
					class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
					placeholder="Title"
					required
					v-model="article.title"
				/>
			</div>
			<div class="mb-6">
				<textarea
					type="text"
					class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
					placeholder="Body"
					v-model="article.body"
				>
				</textarea>
			</div>
			<button
				type="submit"
				class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
			>
				Save
			</button>
		</form>
    <div class="flex flex-col m-5 p-5">
      <nav aria-label="Page navigation example">
        <ul class="inline-flex -space-x-px">
          <li
						class=""
						:class="{disabled: !pagination.prev_page_url}"
					>
            <a
							href="#"
							class="px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
							@click="getArticles(pagination.prev_page_url)"
						>
							Previous
						</a>
          </li>
          <li

					>
          	<a
							href="#"
							class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
						>
							Page {{ pagination.current_page }} of {{ pagination.last_page }}
						</a>
          </li>
          <li
						class=""
						:class="{disabled: !pagination.next_page_url}"
					>
          	<a
							href="#"
							class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
							@click="getArticles(pagination.next_page_url)"
						>
							Next
						</a>
          </li>
        </ul>
      </nav>
    </div>

    <div class="">
      <div
        v-for="(elem, idx) in articles"
        :key="idx"
        class="flex flex-col p-5 m-5"
      >
        <p
					class="text-3xl"
				>
					{{ elem.title }}
				</p>
        <p
					class="text-xl mb-4"
				>
					{{ elem.body }}
				</p>
				<hr />
				<button
					type="button"
					class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2"
					@click="editArticle(elem)"
				>
					Edit
				</button>
				<button
					type="button"
					class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2"
					@click="deleteArticle(elem.id)"
				>
					Delete
				</button>
      </div>
    </div>
  </div>
</template>