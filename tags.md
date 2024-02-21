---
layout: default
title: 标签
permalink: /tags/
---
<div class="col-mb-12 col-8" id="main" role="main">
{% for tag in site.tags %}
<a name="{{ tag | first }}"><h2>&#160;&#160;{{ tag | first }}<sup>{{ tag.last.size }}</sup></h2></a>
    <ul class="post-near">
    {% for post in tag.last %}
      <blockquote><li><a href="{{ post.url }}">{{ post.title }}</a> </li></blockquote>
    {% endfor %}
    </ul>
{% endfor %}
</div>
