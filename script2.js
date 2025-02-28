class Animal {
  constructor(name) {
    this.name = name;
  }
}

class Dog extends Animal {
  bark() {
    console.log('woof! woof!! woof!!');
  }
}

class Cat extends Animal {
  meow() {
    console.log('meooow!');
  }
}

function printAnimalNames(animals) {
  for (let i = 0; i < animals.length; i++) {
    const animal = animals[i];
    console.log(animal.name);
  }
}

const dog = new Dog('Jack');
const cat = new Cat('Zoey');

const animals = [dog, cat];

printAnimalNames(animals);