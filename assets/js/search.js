document.addEventListener("DOMContentLoaded", function() {
  var timer;

  document.getElementById('search-box').addEventListener('input', function() {
      var searchTerm = this.value;

      // Clear any already pending operations
      clearTimeout(timer);

      // Schedule new operation in one second
      timer = setTimeout(function() {
          fetch('assets/php/search.php', {
              method: 'POST',
              body: JSON.stringify({ search: searchTerm }),
              headers: {'Content-Type': 'application/json'}
          })
          .then(response => response.json())
          .then(results => {
              var suggestionsContainer = document.getElementById('suggestions-container');
              suggestionsContainer.innerHTML = "";

              for (var i = 0; i < results.length; i++) {
                  var result = results[i];

                  var item = document.createElement('a');
                  item.href = "knowledge.php?id=" + result.id;
                  item.className = 'list-group-item list-group-item-action';

                  var title = document.createElement('h5');
                  title.className = 'mb-1';
                  title.style.fontSize = '13px';
                  title.textContent = result.title;

                  item.appendChild(title);
                  suggestionsContainer.appendChild(item);
              }

              // Show the container only if there are results
              if (results.length > 0) {
                  suggestionsContainer.style.display = 'block';
              } else {
                  suggestionsContainer.style.display = 'none';
              }
          }).catch(error => console.error('Error:', error));
      }, 1000); // Delay of 1 second
  });

  // Hide results on clicking outside
  document.addEventListener('click', function(event) {
      var suggestionsContainer = document.getElementById('suggestions-container');

      if (!suggestionsContainer || suggestionsContainer.contains(event.target)) {
          return;
      }

      suggestionsContainer.style.display = 'none';
  });
});