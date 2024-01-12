function saveCategory() {
    const mainCategory = document.getElementById('mainCategory').value;
    const subCategory = document.getElementById('subCategory').value;
    const subSubCategory = document.getElementById('subSubCategory').value;
  
    let categories = JSON.parse(localStorage.getItem('categories')) || [];
    categories.push({ mainCategory, subCategory, subSubCategory });
    localStorage.setItem('categories', JSON.stringify(categories));
  
    displayCategories();
    
    // Clear input fields
    document.getElementById('mainCategory').value = '';
    document.getElementById('subCategory').value = '';
    document.getElementById('subSubCategory').value = '';
  }
  
  function displayCategories() {
    const nestedList = document.getElementById('nestedList');
    nestedList.innerHTML = ''; // Clear previous content
  
    const categories = JSON.parse(localStorage.getItem('categories')) || [];
  
    categories.forEach(category => {
      const newItem = document.createElement('li');
      const mainCategory = document.createTextNode(category.mainCategory);
      
      const nestedUl = document.createElement('ul');
      const subItem = document.createElement('li');
      const subCategory = document.createTextNode(category.subCategory);
      
      const subNestedUl = document.createElement('ul');
      const subSubItem = document.createElement('li');
      const subSubCategory = document.createTextNode(category.subSubCategory);
      
      subSubItem.appendChild(subSubCategory);
      subNestedUl.appendChild(subSubItem);
      subItem.appendChild(subCategory);
      subItem.appendChild(subNestedUl);
      nestedUl.appendChild(subItem);
      newItem.appendChild(mainCategory);
      newItem.appendChild(nestedUl);
      nestedList.appendChild(newItem);
    });
  }
  
  // Display saved categories when the page loads
  window.onload = displayCategories;
  