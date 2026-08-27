{extends file="layouts/main.tpl"}

{block name="content"}
    <div class="article-page">
        <div class="article-page__content">
            <h1 class="article-page__title">{$article.name|escape}</h1>

            <div class="article-page__meta">
                <p>{$article.created_at|escape}</p>
                <p>{$article.views|escape} просмотров</p>
            </div>

            {if $article.image}
                <img class="article-page__image" src="{$article.image|escape}" alt="{$article.name|escape}">
            {/if}

            <p class="article-page__description">{$article.description|escape}</p>
            <div class="article-page__text">{$article.text|escape}</div>
        </div>

        <div class="similar-articles">
            <h2 class="similar-articles__title">Похожие статьи</h2>
            <div class="similar-articles__list">
                {foreach $similarArticles as $similar}
                    <div class="article-card">
                        {if $similar.image}
                            <img class="article-card__image" src="{$similar.image|escape}" alt="{$similar.name|escape}">
                        {/if}
                        <div class="article-card__content">
                            <h3 class="article-card__title">{$similar.name|escape}</h3>
                            <p class="article-card__description">{$similar.description|escape}</p>
                        </div>
                    </div>
                {/foreach}

            </div>

        </div>

    </div>

{/block}
