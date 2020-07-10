<template>
  <div id="app">
    <router-view/>
  </div>
</template>

<style>

body, html {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
}

#app {
  display: flex;
  align-items: center;
  height: 100%;
  font-family: 'Roboto', sans-serif;
  font-size: 25px;
  line-height: 40px;
}

.custom-input {
  width: 100%;
  font: inherit;
  border-radius: 10px;
  outline: none;
}

.custom-button {
  width: 100%;
  cursor: pointer;
  font: inherit;
  text-align: center;
  color: black;
  border: 2px solid black;
  border-radius: 10px;
  outline: none;
  background: white;
  text-decoration: none;
  box-shadow: 0px 4px 0px 0px rgb(0, 0, 0, 1);
}

.custom-button:hover {
  background: #747474;
  color: white;
}

input {
  border: 2px solid black;
}

</style>
