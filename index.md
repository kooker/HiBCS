---
layout: default
---	

<div class="col-mb-12 col-8" id="main" role="main">
{% for post in site.posts limit:8 %}
<article class="post" itemscope itemtype="http://schema.org/BlogPosting">
            <h2 class="post-title" itemprop="name headline">
                <a itemprop="url"
                   href="{{ post.url }}">{{ post.title }}</a>
            </h2>
        <ul class="post-meta">
            <li itemprop="author" itemscope itemtype="http://schema.org/Person">
                作者:{{ site.author.name }}
            </li>
            <li>时间: <time datetime="{{ post.date | date:"%b %e, %Y" }}" itemprop="datePublished">{{ post.date | date:"%b %e, %Y" }}</time>
            </li>
            <li>字节: {{ post.content.size }}
            </li>
        </ul>
            <div class="post-content" itemprop="articleBody">
		<blockquote>{{ post.description }}</blockquote>
			</div>
        </article>
			{% endfor %}</div>
