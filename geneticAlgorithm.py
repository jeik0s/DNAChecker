from random import random, choice
from abc import abstractmethod, ABC
import sys


class Element(ABC):
    @abstractmethod
    def __init__(self):
        self.fitness = self.evaluate_function()
    
    def mutation(self):
        self.mutation_of_DNA()
        self.fitness = self.evaluate_function()

    @abstractmethod
    def mutation_of_DNA(self):
        pass

    @abstractmethod
    def crossover_DNA(self, element2: 'Element' ) -> 'Element':
        pass

    @abstractmethod
    def evaluate_function(self):
        pass


class geneticAlgorithm:
    output_data = []

    def __init__(self, first_generation_creator: callable,
                 selection_model: callable, stop_condition: callable, probability_of_themutation_of_DNA: float = 0.15):
        self.first_generation = first_generation_creator
        self.selection_model = selection_model
        
        self.stop_condition = stop_condition
        self.probability_of_themutation_of_DNA = probability_of_themutation_of_DNA

    def run(self):
        population = self.first_generation()
        population.sort(key=lambda x: x.fitness)
        population_len = len(population)
        changedFitness = 0 

        i = 0
        while True:
            selected = self.selection_model(population)
            create_new_population = selected.copy()
            while len(create_new_population) != population_len:
                child = choice(population).crossover_DNA(choice(population))
                if random() <= self.probability_of_themutation_of_DNA:
                    child.mutation()
                create_new_population.append(child)

            population = create_new_population
            the_best_match = min(population, key=lambda x: x.fitness)
            # print("Generation: {} S: {} fitness: {}".format(i, the_best_match, the_best_match.fitness))
            if changedFitness != the_best_match.fitness:
                data = '"Generation": {}, "Changed": "{}"'.format(i, the_best_match)
                self.output_data.append('"'+str(the_best_match.fitness)+'":{'+data+'}')
                changedFitness = the_best_match.fitness
            
            i += 1
            if self.stop_condition(the_best_match, the_best_match.fitness, i):
                return self.output_data
                
