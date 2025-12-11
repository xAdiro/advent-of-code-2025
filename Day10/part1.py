from dataclasses import dataclass
import itertools


def func_detail(func):
    def func_wrapper(*args, **kwargs):
        print(func.__name__)
        print(*args)
        result = func(*args, **kwargs)
        print(f"=> {result}")
        return result
    return func_wrapper


@dataclass
class State:
    max_steps = 4
    prev: "State"
    lights_state: list[bool]
    steps: int

    def shortest_path(self, target_lights: list[bool], buttons):
        if State.max_steps is not None and self.steps >= State.max_steps:
            return float("inf")

        if self.lights_state == target_lights:
            State.max_steps = self.steps
            return self.steps

        next_states = [State(
            prev=self,
            lights_state=button_result(button, self.lights_state),
            steps=self.steps+1)
            if self.is_good_button(button, target_lights) else None
            for button in buttons]

        return min([state.shortest_path(target_lights, buttons)
                    if state is not None else float("inf")
                    for state in next_states])

    def is_good_button(self, button, target_lights):
        for i in button:
            if self.lights_state[i] != target_lights[i]:
                return True
        return False


def button_result(button, lights):
    output = lights.copy()
    for i in button:
        output[i] = not output[i]
    return output


def part1_2():
    with open("input.txt", "r") as f:
        file = f.read().splitlines()

    lines = [line.split(" ") for line in file]

    lights_lines = [[True if light == "#" else False for light in line[0][1:-1]]
                    for line in lines]
    buttons_lines = [[[int(y) for y in x[1:-1].split(",")]
                      for x in line[1:-1]] for line in lines]
    # joltages_lines = [[int(x) for x in line[-1][1:-1].split(",")]
    #                   for line in lines]

    score = 0
    for lights, buttons in zip(lights_lines, buttons_lines):
        score += shortest_path(lights, buttons)

    print(score)


def shortest_path(lights, buttons):
    for n in range(len(buttons)+1):
        buttons_subset = list(itertools.combinations(buttons, n))
        for buttons_2 in buttons_subset:
            result = click_buttons(buttons_2, len(lights))
            if result == lights:
                return n

    raise Exception("no path found")


def click_buttons(buttons, lights_n):
    output = [False]*lights_n

    for button in buttons:
        for i in button:
            output[i] = not output[i]

    return output


def part1():
    with open("example.txt", "r") as f:
        file = f.read().splitlines()

    lines = [line.split(" ") for line in file]

    lights_lines = [[True if light == "#" else False for light in line[0][1:-1]]
                    for line in lines]
    buttons_lines = [[[int(y) for y in x[1:-1].split(",")]
                      for x in line[1:-1]] for line in lines]
    joltages_lines = [[int(x) for x in line[-1][1:-1].split(",")]
                      for line in lines]

    result = 0
    for lights, buttons in zip(lights_lines, buttons_lines):
        root = (State(lights_state=[False] * len(lights), prev=None, steps=0))
        path = root.shortest_path(lights, buttons)
        print(path)
        result += path


if __name__ == '__main__':
    part1_2()
