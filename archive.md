---
layout: default
title: 存档
permalink: /archive/
---
<div class="col-mb-12 col-8" id="main" role="main">
  {% capture post_year1 %}{{ site.time | date: '%Y' }}{% endcapture %}
<h2>&#160;&#160;{{ post_year1 }}</h2>
<ul>
{% for post in site.posts %}
{% capture post_year2 %}{{ post.date | date: '%Y' }}{% endcapture %}
{% if post_year1 != post_year2 %}
{% assign post_year1 = post_year2 %}
</ul>
<h2>&#160;&#160;{{ post_year1 }}</h2>
<ul>
{% endif %}
<blockquote><h3><span>{{ post.date | date: "%b %d, %Y" }}</span> &raquo;  <a href="{{ post.url }}">{{ post.title }}</a> </h3></blockquote>
{% endfor %}
</ul>
</div>

<div class="sa_right clearfix">
<div class="sa_right_title"><span>标签云</span></div>
<div class="sa_articleinfo top_box">
<div class="sa_articletag clearfix">  
{% for tag in site.tags %}
<a href="/tags/#{{ tag | first }}">{{ tag | first }}<sup>{{ tag.last.size }}</sup></a>
{% endfor %}</div>
</div>
