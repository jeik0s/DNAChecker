from random import random, choice
from abc import abstractmethod, ABC
import sys


class Element(ABC):
    @abstractmethod
    def __init__(self):
        self.fitness = self.evaluate_function()

    def mutation(self):
        self._mutation()
        self.fitness = self.evaluate_function()

    @abstractmethod
    def _mutation(self):
        pass

    @abstractmethod
    def crossover2DNA(self, element2: 'Element' ) -> 'Element':
        pass

    @abstractmethod
    def evaluate_function(self):
        pass


class genetic_algorithm:
    output_data = []

    def __init__(self, generate_first_new_population: callable,
                 selection_model: callable, stop_condition: callable, probability_of_the_mutation: float = 0.1):
        self.first_generation = generate_first_new_population
        self.selection_model = selection_model
        
        self.stop_condition = stop_condition
        self.probability_of_the_mutation = probability_of_the_mutation

    def run(self):
        population = self.first_generation()
        population.sort(key=lambda x: x.fitness)
        population_len = len(population)
        changedFitness = 0 

        i = 0
        while True:
            selected = self.selection_model(population)
            new_population = selected.copy()
            while len(new_population) != population_len:
                child = choice(population).crossover2DNA(choice(population))
                if random() <= self.probability_of_the_mutation:
                    child.mutation()
                new_population.append(child)

            population = new_population
            the_best_match = min(population, key=lambda x: x.fitness)
            # print("Generation: {} S: {} fitness: {}".format(i, the_best_match, the_best_match.fitness))
            if changedFitness != the_best_match.fitness:
                data = '"Generation": {}, "Changed": "{}"'.format(i, the_best_match)
                self.output_data.append('"'+str(the_best_match.fitness)+'":{'+data+'}')
                changedFitness = the_best_match.fitness
            
            i += 1
            if self.stop_condition(the_best_match, the_best_match.fitness, i):
                return self.output_data
                
