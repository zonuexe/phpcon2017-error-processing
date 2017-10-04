<table border>
    <tr>
        <th>name</th>
        <th>enabled</th>
    </tr>
    {% for f in features %}
        <tr>
            <td><code>{{ f.key }}</code></td>
            <td>{{ feature_value(f.value) }}</td>
        </tr>
    {% endfor %}
</table>
