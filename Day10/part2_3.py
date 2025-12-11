import pulp


def part2():
    with open("input.txt", "r") as f:
        file = f.read().splitlines()

    lines = [line.split(" ") for line in file]

    buttons_lines = [[[int(y) for y in x[1:-1].split(",")]
                      for x in line[1:-1]] for line in lines]
    joltages_lines = [tuple(int(x) for x in line[-1][1:-1].split(","))
                      for line in lines]

    score = 0
    for buttons, joltages in zip(buttons_lines, joltages_lines):
        score += fewest_clicks(buttons, joltages)

    print(score)


def fewest_clicks(buttons, target):
    j_len = len(target)
    b_len = len(buttons)
    problem = pulp.LpProblem("MinPresses", pulp.LpMinimize)

    x = [pulp.LpVariable(f"x{i}", lowBound=0, cat='Integer')
         for i in range(b_len)]
    problem += pulp.lpSum(x)

    for pos in range(j_len):
        problem += pulp.lpSum(x[i] for i in range(b_len)
                              if pos in buttons[i]) == target[pos]

    status = problem.solve(pulp.PULP_CBC_CMD(msg=0))
    if status != 1:
        raise Exception("cant solve!!!")
    return int(pulp.value(problem.objective))


if __name__ == "__main__":
    part2()
