{% if available_features %}
    <form method="post" action="{{ url_to('post_feature') }}">
{% endif %}
<table border>
    <tr>
        <th>name</th>
        <th>enabled</th>
        {% if available_features %}
            <th>available_features</th>
        {% endif %}
    </tr>
    {% for f in features %}
        <tr>
            <td><code>{{ f.key }}</code></td>
            <td>{{ feature_value(f.value) }}</td>
            {% if available_features -%}
                <td>
                    <select name="{{ f.key }}">
                        {%- for a in available_features[f.key] -%}
                            <option value="{{ feature_value(a) }}"><code>{{ feature_value(a) }}</code></option>
                        {%- endfor -%}
                    </select>
                </td>
            {% endif -%}
        </tr>
    {% endfor %}
</table>
{% if available_features %}
    <button type="submit">送信</button>
    </form>
{% endif %}
